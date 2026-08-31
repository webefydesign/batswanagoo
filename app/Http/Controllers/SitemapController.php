<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Categories;
use App\Models\Advertise;
use App\Models\Pages;
use App\Models\User;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Main sitemap index
     * /sitemap.xml
     */
    public function index()
    {
        $sitemaps = [
            [
                'loc' => route('sitemap.pages'),
                'lastmod' => now()->toAtomString(),
            ],
            [
                'loc' => route('sitemap.categories'),
                'lastmod' => Categories::latest()->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
            ],
            [
                'loc' => route('sitemap.ads'),
                'lastmod' => Advertise::latest()->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
            ],
            [
                'loc' => route('sitemap.blogs'),
                'lastmod' => Blogs::latest()->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
            ],
            [
                'loc' => route('sitemap.brands'),
                'lastmod' => $this->dedicatedBrandUsersQuery()->latest('updated_at')->first()?->updated_at?->toAtomString() ?? now()->toAtomString(),
            ],
        ];

        return response()->view('sitemap.index', compact('sitemaps'), 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Static pages sitemap
     * /sitemap-pages.xml
     */
    public function pages()
    {
        $urls = [];

        // Home page
        $urls[] = [
            'loc' => route('home'),
            'changefreq' => 'weekly',
            'priority' => '1.0',
            'lastmod' => now()->toAtomString(),
        ];

        // Categories index page
        $urls[] = [
            'loc' => url('/categories'),
            'changefreq' => 'daily',
            'priority' => '0.9',
            'lastmod' => now()->toAtomString(),
        ];

        // Blogs index page
        $urls[] = [
            'loc' => route('blogsPage'),
            'changefreq' => 'daily',
            'priority' => '0.9',
            'lastmod' => now()->toAtomString(),
        ];

        // Top-level static pages from Pages table
        // (Pages::page($slug, $sub) expects a 2-segment URL for child pages,
        // so we build those separately below instead of flattening everything.)
        $pages = Pages::where('is_active', 1)->whereNull('parent_id')->get();

        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('dynamicPage', $page->slug),
                'changefreq' => 'monthly',
                'priority' => '0.7',
                'lastmod' => $page->updated_at->toAtomString(),
            ];

            // Child pages of this parent
            $children = Pages::where('is_active', 1)
                ->where('parent_id', $page->id)
                ->get();

            foreach ($children as $child) {
                $urls[] = [
                    'loc' => route('dynamicPage', [$page->slug, $child->slug]),
                    'changefreq' => 'monthly',
                    'priority' => '0.6',
                    'lastmod' => $child->updated_at->toAtomString(),
                ];
            }
        }

        return response()->view('sitemap.urls', compact('urls'), 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Categories sitemap
     * /sitemap-categories.xml
     */
    public function categories()
    {
        $urls = [];

        // Get main categories
        $mainCategories = Categories::where('parent_id', null)
            ->where('is_active', 1)
            ->get();

        foreach ($mainCategories as $category) {
            // Add main category
            $urls[] = [
                'loc' => url('categories/' . $category->slug),
                'changefreq' => 'daily',
                'priority' => '0.8',
                'lastmod' => $category->updated_at->toAtomString(),
            ];

            // Add sub-categories
            $subCategories = $category->childrens()->where('is_active', 1)->get();
            foreach ($subCategories as $subCategory) {
                $urls[] = [
                    'loc' => url('categories/' . $category->slug . '/' . $subCategory->slug),
                    'changefreq' => 'daily',
                    'priority' => '0.7',
                    'lastmod' => $subCategory->updated_at->toAtomString(),
                ];
            }
        }

        return response()->view('sitemap.urls', compact('urls'), 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Ads/Advertise sitemap
     * /sitemap-ads.xml
     */
    public function ads()
    {
        $urls = [];

        // Get all active ads
        $ads = Advertise::where('status', 'active')
            ->with(['category'])
            ->get();

        foreach ($ads as $ad) {
            // Build the URL based on category hierarchy
            $url = $this->buildAdUrl($ad);

            $urls[] = [
                'loc' => $url,
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'lastmod' => $ad->updated_at->toAtomString(),
            ];
        }

        return response()->view('sitemap.urls', compact('urls'), 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Blogs sitemap
     * /sitemap-blogs.xml
     */
    public function blogs()
    {
        $urls = [];

        // Get all active, published blogs.
        // NOTE: Blogs model has no `published` column — using `publish_date`
        // (a fillable field on the model) as the scheduling gate instead.
        $blogs = Blogs::where('is_active', 1)
            ->where('publish_date', '<=', now())
            ->latest()
            ->get();

        foreach ($blogs as $blog) {
            $urls[] = [
                'loc' => route('blogDetail', $blog->slug),
                'changefreq' => 'weekly',
                'priority' => '0.7',
                'lastmod' => $blog->updated_at->toAtomString(),
            ];
        }

        return response()->view('sitemap.urls', compact('urls'), 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Brand/seller storefront sitemap
     * /sitemap-brands.xml
     */
    public function brands()
    {
        $urls = [];

        $users = $this->dedicatedBrandUsersQuery()->get();

        foreach ($users as $user) {
            $urls[] = [
                'loc' => route('shop', $user->slug),
                'changefreq' => 'weekly',
                'priority' => '0.6',
                'lastmod' => $user->updated_at->toAtomString(),
            ];
        }

        return response()->view('sitemap.urls', compact('urls'), 200)
            ->header('Content-Type', 'application/xml; charset=utf-8');
    }

    /**
     * Users with a public storefront page (`brands/{slug}` / the `shop`
     * route) - matches the criteria used to list them on the Brands page.
     */
    private function dedicatedBrandUsersQuery()
    {
        return User::whereNotNull('slug')
            ->where('is_active', 1)
            ->where('is_verified', 1)
            ->where('user_type', 'customer');
    }

    /**
     * Build full URL for an ad based on its category hierarchy
     */
    private function buildAdUrl($ad)
    {
        if (!$ad->category) {
            return url('ads/' . $ad->slug);
        }

        $category = $ad->category;
        $slugs = [$ad->slug];

        // Build category path (parent -> child -> grandchild -> slug)
        while ($category) {
            array_unshift($slugs, $category->slug);
            $category = $category->parent;
        }

        return url('categories/' . implode('/', $slugs));
    }
    
}