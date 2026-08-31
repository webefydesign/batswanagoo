<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PagesController;

use App\Http\Controllers\MakeController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\BodyTypeController;
use App\Http\Controllers\FieldsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PlanTypeController;
use App\Http\Controllers\PlansController;

use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsCategoryController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\EventsCategoryController;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TestimonialsController;
use App\Http\Controllers\ChatStickersController;
use App\Http\Controllers\ConfigurationsController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\UserGroupController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RedirectionsController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PromoteController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SafetyController;
use App\Http\Controllers\SalonegooFaqController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\SitemapController;
use App\Http\Middleware\AllowForAdmin;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Broadcast;

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/get-states/{countryId}', [HomeController::class, 'getStates'])->name('getStates');
Route::get('/get-cities/{stateId}', [HomeController::class, 'getCities']);

Route::get('auth/google', [HomeController::class, 'redirectToGoogle'])->name('googleAuth');
Route::get('auth/google/callback', [HomeController::class, 'handleGoogleCallback'])->name('googleCallback');

Route::post('admin/fetchMakeModels', [MakeController::class, 'fetchMakeModels'])->name('fetchMakeModels');

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('sitemap-pages.xml', [SitemapController::class, 'pages'])->name('sitemap.pages');
Route::get('sitemap-categories.xml', [SitemapController::class, 'categories'])->name('sitemap.categories');
Route::get('sitemap-ads.xml', [SitemapController::class, 'ads'])->name('sitemap.ads');
Route::get('sitemap-blogs.xml', [SitemapController::class, 'blogs'])->name('sitemap.blogs');
Route::get('sitemap-brands.xml', [SitemapController::class, 'brands'])->name('sitemap.brands');

// Route::get('rollback', [HomeController::class, 'rollback']);

Route::middleware(['auth', AllowForAdmin::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [AdminController::class, 'dashboardChartData'])->name('dashboard.chartData');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profilePage');
    Route::post('/profile', [AdminController::class, 'update_profile'])->name('updateProfile');

    /* Wallet Routes */
    Route::get('/wallet-payments', [AdminController::class, 'walletPayments'])->name('admin.walletPayments');
    Route::post('/wallet-payments/approve', [AdminController::class, 'approveWalletPayment'])->name('admin.approveWalletPayment');
    Route::post('/wallet-payments/settings', [AdminController::class, 'walletSettings'])->name('admin.walletSettings');

    /* Make Routes */
    Route::get('/make', [MakeController::class, 'index'])->name('make.index');
    Route::post('/make/store', [MakeController::class, 'store'])->name('make.store');
    Route::post('/make/{id}/update', [MakeController::class, 'update'])->name('make.update');
    Route::get('/make/{id}/status', [MakeController::class, 'status'])->name('make.status');
    Route::post('/make/delete-all', [MakeController::class, 'delete'])->name('make.delete');
    

    /* Vehicle Body Types Routes */
    Route::get('/body-types', [BodyTypeController::class, 'index'])->name('body-types.index');
    Route::post('/body-types/store', [BodyTypeController::class, 'store'])->name('body-types.store');
    Route::post('/body-types/{id}/update', [BodyTypeController::class, 'update'])->name('body-types.update');
    Route::get('/body-types/{id}/status', [BodyTypeController::class, 'status'])->name('body-types.status');
    Route::post('/body-types/delete-all', [BodyTypeController::class, 'delete'])->name('body-types.delete');

    /* Model Routes */
    Route::get('/models', [ModelController::class, 'index'])->name('models.index');
    Route::post('/models/store', [ModelController::class, 'store'])->name('models.store');
    Route::post('/models/{id}/update', [ModelController::class, 'update'])->name('models.update');
    Route::get('/models/{id}/status', [ModelController::class, 'status'])->name('models.status');
    Route::post('/models/delete-all', [ModelController::class, 'delete'])->name('models.delete');

    /* Brands Routes */
    Route::get('/brands', [BrandsController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
    Route::post('/brands/store', [BrandsController::class, 'store'])->name('brands.store');
    Route::get('/brands/{id}/edit', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::post('/brands/{id}/update', [BrandsController::class, 'update'])->name('brands.update');
    Route::get('/brands/{id}/status', [BrandsController::class, 'status'])->name('brands.status');
    Route::post('/brands/delete-all', [BrandsController::class, 'delete'])->name('brands.delete');

    /* Categories Routes */
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::post('/categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{id}/status', [CategoryController::class, 'status'])->name('categories.status');
    Route::get('/categories/{id}/display', [CategoryController::class, 'display'])->name('categories.display');
    Route::get('/categories/{id}/special', [CategoryController::class, 'special'])->name('categories.special');
    Route::post('/categories/delete-all', [CategoryController::class, 'delete'])->name('categories.delete');
    
    /* Sub Categories Routes */
    Route::get('/sub-categories', [CategoryController::class, 'sub_categories_index'])->name('sub-categories.index');
    Route::get('/sub-categories/create', [CategoryController::class, 'sub_categories_create'])->name('sub-categories.create');
    Route::post('/sub-categories/store', [CategoryController::class, 'sub_categories_store'])->name('sub-categories.store');
    Route::get('/sub-categories/{id}/edit', [CategoryController::class, 'sub_categories_edit'])->name('sub-categories.edit');
    Route::post('/sub-categories/{id}/update', [CategoryController::class, 'sub_categories_update'])->name('sub-categories.update');
    Route::get('/sub-categories/{id}/status', [CategoryController::class, 'sub_categories_status'])->name('sub-categories.status');
    Route::get('/sub-categories/{id}/display', [CategoryController::class, 'sub_categories_display'])->name('sub-categories.display');
    Route::get('/sub-categories/{id}/special', [CategoryController::class, 'sub_categories_special'])->name('sub-categories.special');
    Route::post('/sub-categories/delete-all', [CategoryController::class, 'sub_categories_delete'])->name('sub-categories.delete');

    /* Promotions Routes */
    Route::get('/promote', [PromoteController::class, 'index'])->name('promote.index');
    Route::get('/promote/create', [PromoteController::class, 'create'])->name('promote.create');
    Route::post('/promote/store', [PromoteController::class, 'store'])->name('promote.store');
    Route::get('/promote/{id}/edit', [PromoteController::class, 'edit'])->name('promote.edit');
    Route::post('/promote/{id}/update', [PromoteController::class, 'update'])->name('promote.update');
    Route::get('/promote/{id}/status', [PromoteController::class, 'status'])->name('promote.status');
    Route::post('/promote/delete-all', [PromoteController::class, 'delete'])->name('promote.delete');


    /* Currencies Routes */
    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
    Route::get('/currencies/create', [CurrencyController::class, 'create'])->name('currencies.create');
    Route::post('/currencies/store', [CurrencyController::class, 'store'])->name('currencies.store');
    Route::get('/currencies/{id}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
    Route::post('/currencies/{id}/update', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::get('/currencies/{id}/status', [CurrencyController::class, 'status'])->name('currencies.status');
    Route::post('/currencies/delete-all', [CurrencyController::class, 'delete'])->name('currencies.delete');

    /* FAQS Routes */
    Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
    Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
    Route::post('/faqs/store', [FaqController::class, 'store'])->name('faqs.store');
    Route::get('/faqs/{id}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
    Route::post('/faqs/{id}/update', [FaqController::class, 'update'])->name('faqs.update');
    Route::get('/faqs/{id}/status', [FaqController::class, 'status'])->name('faqs.status');
    Route::post('/faqs/delete-all', [FaqController::class, 'delete'])->name('faqs.delete');

    /* Salonegoo FAQS Routes */
    Route::get('/salonegoo_faqs', [SalonegooFaqController::class, 'index'])->name('salonegoo_faqs.index');
    Route::get('/salonegoo_faqs/create', [SalonegooFaqController::class, 'create'])->name('salonegoo_faqs.create');
    Route::post('/salonegoo_faqs/store', [SalonegooFaqController::class, 'store'])->name('salonegoo_faqs.store');
    Route::get('/salonegoo_faqs/{id}/edit', [SalonegooFaqController::class, 'edit'])->name('salonegoo_faqs.edit');
    Route::post('/salonegoo_faqs/{id}/update', [SalonegooFaqController::class, 'update'])->name('salonegoo_faqs.update');
    Route::get('/salonegoo_faqs/{id}/status', [SalonegooFaqController::class, 'status'])->name('salonegoo_faqs.status');
    Route::post('/salonegoo_faqs/delete-all', [SalonegooFaqController::class, 'delete'])->name('salonegoo_faqs.delete');

    /* Safeties Routes */
    Route::get('/safeties', [SafetyController::class, 'index'])->name('safeties.index');
    Route::get('/safeties/create', [SafetyController::class, 'create'])->name('safeties.create');
    Route::post('/safeties/store', [SafetyController::class, 'store'])->name('safeties.store');
    Route::get('/safeties/{id}/edit', [SafetyController::class, 'edit'])->name('safeties.edit');
    Route::post('/safeties/{id}/update', [SafetyController::class, 'update'])->name('safeties.update');
    Route::get('/safeties/{id}/status', [SafetyController::class, 'status'])->name('safeties.status');
    Route::post('/safeties/delete-all', [SafetyController::class, 'delete'])->name('safeties.delete');

    /* Slider Routes */
    Route::get('/sliders', [SliderController::class, 'index'])->name('sliders.index');
    Route::get('/sliders/create', [SliderController::class, 'create'])->name('sliders.create');
    Route::post('/sliders/store', [SliderController::class, 'store'])->name('sliders.store');
    Route::get('/sliders/{id}/edit', [SliderController::class, 'edit'])->name('sliders.edit');
    Route::post('/sliders/{id}/update', [SliderController::class, 'update'])->name('sliders.update');
    Route::get('/sliders/{id}/status', [SliderController::class, 'status'])->name('sliders.status');
    Route::post('/sliders/delete-all', [SliderController::class, 'delete'])->name('sliders.delete');

    /* Fields Routes */
    Route::get('/fields', [FieldsController::class, 'index'])->name('fields.index');
    Route::get('/fields/create', [FieldsController::class, 'create'])->name('fields.create');
    Route::post('/fields/store', [FieldsController::class, 'store'])->name('fields.store');
    Route::get('/fields/{id}/edit', [FieldsController::class, 'edit'])->name('fields.edit');
    Route::post('/fields/{id}/update', [FieldsController::class, 'update'])->name('fields.update');
    Route::get('/fields/{id}/status', [FieldsController::class, 'status'])->name('fields.status');
    Route::post('/fields/delete-all', [FieldsController::class, 'delete'])->name('fields.delete');

    /* Plan Types Routes - disabled: ad posting no longer requires a plan/plan type.
    Route::get('/plan-types', [PlanTypeController::class, 'index'])->name('plan-types.index');
    Route::get('/plan-types/create', [PlanTypeController::class, 'create'])->name('plan-types.create');
    Route::post('/plan-types/store', [PlanTypeController::class, 'store'])->name('plan-types.store');
    Route::get('/plan-types/{id}/edit', [PlanTypeController::class, 'edit'])->name('plan-types.edit');
    Route::post('/plan-types/{id}/update', [PlanTypeController::class, 'update'])->name('plan-types.update');
    Route::get('/plan-types/{id}/status', [PlanTypeController::class, 'status'])->name('plan-types.status');
    Route::post('/plan-types/delete-all', [PlanTypeController::class, 'delete'])->name('plan-types.delete');
    */

    Route::get('/plans', [PlansController::class, 'index'])->name('plans.index');
    Route::get('/plans/create', [PlansController::class, 'create'])->name('plans.create');
    Route::post('/plans/store', [PlansController::class, 'store'])->name('plans.store');
    Route::get('/plans/{id}/edit', [PlansController::class, 'edit'])->name('plans.edit');
    Route::post('/plans/{id}/update', [PlansController::class, 'update'])->name('plans.update');
    Route::get('/plans/{id}/status', [PlansController::class, 'status'])->name('plans.status');
    Route::post('/plans/delete-all', [PlansController::class, 'delete'])->name('plans.delete');
    Route::post('plans/ajax-types', [PlansController::class, 'planPoints'])->name('ajaxPlanPoints');

    /* Pages Routes */
    Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
    Route::get('/pages/create', [PagesController::class, 'create'])->name('pages.create');
    Route::post('/pages/store', [PagesController::class, 'store'])->name('pages.store');
    Route::get('/pages/{id}/edit', [PagesController::class, 'edit'])->name('pages.edit');
    Route::post('/pages/{id}/update', [PagesController::class, 'update'])->name('pages.update');
    Route::get('/pages/{id}/status', [PagesController::class, 'status'])->name('pages.status');
    Route::get('/pages/{id}/delete', [PagesController::class, 'delete'])->name('pages.delete');
    Route::post('/pages/get-components', [PagesController::class, 'getComponent'])->name('ajaxGetComps');

    /* Clients */
    Route::get('/clients', [ClientsController::class, 'index'])->name('clients.index');
    Route::post('/clients/store', [ClientsController::class, 'store'])->name('clients.store');
    Route::post('/clients/{id}/update', [ClientsController::class, 'update'])->name('clients.update');
    Route::get('/clients/{id}/status', [ClientsController::class, 'status'])->name('clients.status');
    Route::post('/clients/delete-all', [ClientsController::class, 'delete'])->name('clients.delete');

    /* Chat Stickers */
    Route::get('/chat-stickers', [ChatStickersController::class, 'index'])->name('chat-stickers.index');
    Route::post('/chat-stickers/store', [ChatStickersController::class, 'store'])->name('chat-stickers.store');
    Route::post('/chat-stickers/{id}/update', [ChatStickersController::class, 'update'])->name('chat-stickers.update');
    Route::get('/chat-stickers/{id}/status', [ChatStickersController::class, 'status'])->name('chat-stickers.status');
    Route::post('/chat-stickers/delete-all', [ChatStickersController::class, 'delete'])->name('chat-stickers.delete');

    /* Testimonials */
    Route::get('/testimonials', [TestimonialsController::class, 'index'])->name('testimonials.index');
    Route::post('/testimonials/store', [TestimonialsController::class, 'store'])->name('testimonials.store');
    Route::post('/testimonials/{id}/update', [TestimonialsController::class, 'update'])->name('testimonials.update');
    Route::get('/testimonials/{id}/status', [TestimonialsController::class, 'status'])->name('testimonials.status');
    Route::post('/testimonials/delete-all', [TestimonialsController::class, 'delete'])->name('testimonials.delete');

    /* Services Routes */
    Route::get('/services', [ServicesController::class, 'index'])->name('services.index');
    Route::get('/services/create', [ServicesController::class, 'create'])->name('services.create');
    Route::post('/services/store', [ServicesController::class, 'store'])->name('services.store');
    Route::get('/services/{id}/edit', [ServicesController::class, 'edit'])->name('services.edit');
    Route::post('/services/{id}/update', [ServicesController::class, 'update'])->name('services.update');
    Route::get('/services/{id}/status', [ServicesController::class, 'status'])->name('services.status');
    Route::post('/services/delete-all', [ServicesController::class, 'delete'])->name('services.delete');

    /* News Routes */
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{id}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::post('/news/{id}/update', [NewsController::class, 'update'])->name('news.update');
    Route::get('/news/{id}/status', [NewsController::class, 'status'])->name('news.status');
    Route::post('/news/delete-all', [NewsController::class, 'delete'])->name('news.delete');
    Route::post('/news/update-seo', [NewsController::class, 'seo'])->name('news.seo');

    Route::get('/news-categories', [NewsCategoryController::class, 'index'])->name('news-categories.index');
    Route::post('/news-categories/store', [NewsCategoryController::class, 'store'])->name('news-categories.store');
    Route::post('/news-categories/{id}/update', [NewsCategoryController::class, 'update'])->name('news-categories.update');
    Route::get('/news-categories/{id}/status', [NewsCategoryController::class, 'status'])->name('news-categories.status');
    Route::post('/news-categories/delete-all', [NewsCategoryController::class, 'delete'])->name('news-categories.delete');

    /* Blogs Routes */
    Route::get('/blogs', [BlogsController::class, 'index'])->name('blogs.index');
    Route::get('/blogs/create', [BlogsController::class, 'create'])->name('blogs.create');
    Route::post('/blogs/store', [BlogsController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{id}/edit', [BlogsController::class, 'edit'])->name('blogs.edit');
    Route::post('/blogs/{id}/update', [BlogsController::class, 'update'])->name('blogs.update');
    Route::get('/blogs/{id}/status', [BlogsController::class, 'status'])->name('blogs.status');
    Route::post('/blogs/delete-all', [BlogsController::class, 'delete'])->name('blogs.delete');
    Route::post('/blogs/update-seo', [BlogsController::class, 'seo'])->name('blogs.seo');

    Route::get('/blogs-categories', [BlogCategoryController::class, 'index'])->name('blogs-categories.index');
    Route::post('/blogs-categories/store', [BlogCategoryController::class, 'store'])->name('blogs-categories.store');
    Route::post('/blogs-categories/{id}/update', [BlogCategoryController::class, 'update'])->name('blogs-categories.update');
    Route::get('/blogs-categories/{id}/status', [BlogCategoryController::class, 'status'])->name('blogs-categories.status');
    Route::post('/blogs-categories/delete-all', [BlogCategoryController::class, 'delete'])->name('blogs-categories.delete');

    /* Events Routes */
    Route::get('/events', [EventsController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventsController::class, 'create'])->name('events.create');
    Route::post('/events/store', [EventsController::class, 'store'])->name('events.store');
    Route::get('/events/{id}/edit', [EventsController::class, 'edit'])->name('events.edit');
    Route::post('/events/{id}/update', [EventsController::class, 'update'])->name('events.update');
    Route::get('/events/{id}/status', [EventsController::class, 'status'])->name('events.status');
    Route::post('/events/delete-all', [EventsController::class, 'delete'])->name('events.delete');
    Route::post('/events/update-seo', [EventsController::class, 'seo'])->name('events.seo');

    Route::get('/events-categories', [EventsCategoryController::class, 'index'])->name('events-categories.index');
    Route::post('/events-categories/store', [EventsCategoryController::class, 'store'])->name('events-categories.store');
    Route::post('/events-categories/{id}/update', [EventsCategoryController::class, 'update'])->name('events-categories.update');
    Route::get('/events-categories/{id}/status', [EventsCategoryController::class, 'status'])->name('events-categories.status');
    Route::post('/events-categories/delete-all', [EventsCategoryController::class, 'delete'])->name('events-categories.delete');

    /* Albums Routes */
    Route::get('/albums', [AlbumsController::class, 'index'])->name('albums.index');
    Route::get('/albums/create', [AlbumsController::class, 'create'])->name('albums.create');
    Route::post('/albums/store', [AlbumsController::class, 'store'])->name('albums.store');
    Route::get('/albums/{id}/edit', [AlbumsController::class, 'edit'])->name('albums.edit');
    Route::post('/albums/{id}/update', [AlbumsController::class, 'update'])->name('albums.update');
    Route::get('/albums/{id}/status', [AlbumsController::class, 'status'])->name('albums.status');
    Route::post('/albums/delete-all', [AlbumsController::class, 'delete'])->name('albums.delete');

    /* Users Routes */
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::get('/users/{id}/status', [UserController::class, 'status'])->name('users.status');
    Route::post('/users/delete-all', [UserController::class, 'delete'])->name('users.delete');

    /* Customers Routes */
    Route::get('/customers', [UserController::class, 'customers'])->name('customers.index');
    Route::get('/customers/{id}/edit', [UserController::class, 'customer_edit'])->name('customers.edit');
    Route::post('/customers/{id}/update', [UserController::class, 'customer_update'])->name('customers.update');
    Route::get('/customers/{id}/status', [UserController::class, 'customer_status'])->name('customers.status');
    Route::get('/customers/{id}/verify', [UserController::class, 'customer_verify'])->name('customers.verify');
    Route::post('/customers/delete-all', [UserController::class, 'customer_delete'])->name('customers.delete');

    Route::get('/activity-logs', [UserController::class, 'logs'])->name('logsPage');
    Route::get('/customer-logs', [UserController::class, 'customer_logs'])->name('customersLogs');

    /* User Groups Routes */
    Route::get('/user-groups', [UserGroupController::class, 'index'])->name('usergroups.index');
    Route::get('/user-groups/create', [UserGroupController::class, 'create'])->name('usergroups.create');
    Route::post('/user-groups/store', [UserGroupController::class, 'store'])->name('usergroups.store');
    Route::get('/user-groups/{id}/edit', [UserGroupController::class, 'edit'])->name('usergroups.edit');
    Route::post('/user-groups/{id}/update', [UserGroupController::class, 'update'])->name('usergroups.update');
    Route::get('/user-groups/{id}/status', [UserGroupController::class, 'status'])->name('usergroups.status');
    Route::post('/user-groups/delete-all', [UserGroupController::class, 'delete'])->name('usergroups.delete');

    /* ================================ Menus ========================*/
    Route::get('/menus',[MenuController::class, 'index'])->name('menuEditor');
    Route::get('/menus/{id}/edit',[MenuController::class, 'edit'])->name('editMenu');
    Route::post('/menus/store',[MenuController::class, 'store'])->name('storeMenu');
    Route::post('/menus/{id}/update',[MenuController::class, 'update'])->name('updateMenu');
    Route::post('/menus/{id}/delete',[MenuController::class, 'delete'])->name('deleteMenu');
    Route::post('/menus/add-item',[MenuController::class, 'add_item'])->name('addMenuItem');

    /* Redirections */
    Route::get('/redirections', [RedirectionsController::class, 'index'])->name('redirections.index');
    Route::post('/redirections/store', [RedirectionsController::class, 'store'])->name('redirections.store');
    Route::post('/redirections/{id}/update', [RedirectionsController::class, 'update'])->name('redirections.update');
    Route::get('/redirections/{id}/status', [RedirectionsController::class, 'status'])->name('redirections.status');
    Route::post('/redirections/delete-all', [RedirectionsController::class, 'delete'])->name('redirections.delete');

    /* Redirections */
    Route::get('advertises', [AdminController::class, 'advertises'])->name('advertises.index');
    Route::get('advertises/{id}/edit', [AdminController::class, 'editAdvertise'])->name('advertises.edit');
    Route::put('advertises/{id}', [AdminController::class, 'updateAdvertise'])->name('advertises.update');
    Route::get('advertises/cities/{stateName}', [AdminController::class, 'getCitiesByStateName'])->name('advertises.cities');
    Route::post('advertises/status', [AdminController::class, 'advertise_status'])->name('advertises.status');
    Route::post('/advertises/delete-all', [AdminController::class, 'deleteAds'])->name('advertises.delete');
    Route::get('advertises/{id}/seo', [AdminController::class, 'getAdvertiseSeo'])->name('advertises.seo');
    Route::post('advertises/{id}/seo', [AdminController::class, 'updateAdvertiseSeo'])->name('advertises.seo.update');
    Route::get('reports', [AdminController::class, 'reports'])->name('reports.index');
    Route::post('/reports/delete-all', [RedirectionsController::class, 'delete'])->name('reports.delete');
    Route::post('advertises-status', [HomeController::class, 'statusChangeAd']);
    Route::post('advertises-seo', [HomeController::class, 'adSEOUpdate'])->name('adSEOUpdate');

    /* ================================ Additional ========================*/
    Route::get('/configurations',[ConfigurationsController::class, 'index'])->name('configurationPage');
    Route::post('/configurations/update',[ConfigurationsController::class, 'update'])->name('updateConfiguration');

    Route::get('/inbox',[InboxController::class, 'index'])->name('inboxPage');
    Route::post('/inbox/delete-all',[InboxController::class, 'delete_inbox'])->name('deleteInbox');
    Route::get('/subscribers',[InboxController::class, 'subscribers'])->name('subscribersPage');
    Route::post('/subscribers/delete-all',[InboxController::class, 'delete_subscribers'])->name('deleteSubscribers');
    Route::get('/careers',[InboxController::class, 'careers'])->name('careersPage');
    Route::post('/careers/delete-all',[InboxController::class, 'delete_careers'])->name('deleteCareers');

    Route::get('/blog-comments',[AdminController::class, 'blog_comments'])->name('blogCommentsList');
    Route::get('/blog-comments/{id}/status', [AdminController::class, 'approve_comment'])->name('activeBlogComment');
    Route::post('/blog-comments/delete-all',[AdminController::class, 'delete_comments'])->name('deletAllComments');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

require __DIR__.'/auth.php';

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('front.dashboard');
    Route::get('/my_ads', [DashboardController::class, 'my_ads'])->name('dashboard.my_ads');
    Route::get('/editPost/{id}', [DashboardController::class, 'editPost'])->name('dashboard.editPost');
    Route::post('/add-update', [DashboardController::class, 'storeUpdate'])->name('updateStore');

    /* Wallet Routes */
    Route::get('/wallet', [WalletController::class, 'index'])->name('dashboard.wallet');
    Route::post('/wallet/create-intent', [WalletController::class, 'createIntent'])->name('createWalletIntent');
    Route::post('/wallet/confirm-payment', [WalletController::class, 'confirmPayment'])->name('confirmWalletPayment');
    /* End Wallet Routes */

    Route::get('/wishlist', [DashboardController::class, 'my_list'])->name('dashboard.my_list');
    Route::get('/performance/{month?}', [DashboardController::class, 'performance'])->name('dashboard.performance');

    Route::get('/chat', [ChatController::class, 'chat'])->name('dashboard.chat');
    Route::get('/mymsg', [DashboardController::class, 'mymsg'])->name('dashboard.mymsg');
    Route::post('/ajax-mymsg-detail', [DashboardController::class, 'mymsgDetail'])->name('dashboard.mymsgDetail');


    Route::post('/publishAd', [DashboardController::class, 'publishAd'])->name('dashboard.publishAd');
    Route::post('/add-destroy', [DashboardController::class, 'storeDestroy'])->name('dashboard.destroyStore');

    Route::get('feedback/{id?}', [DashboardController::class, 'feedback'])->name('feedback');
    Route::post('feedback-process', [DashboardController::class, 'feedbackProcess'])->name('feedbackProcess');
    Route::post('feedback-mail', [DashboardController::class, 'feedbackMail'])->name('feedbackMail');

    Route::get('profile', [DashboardController::class, 'profile'])->name('dashboard.profile');
    Route::post('profile', [DashboardController::class, 'updateProfile'])->name('dashboard.updateProfile');

    Route::get('business-information', [DashboardController::class, 'businessInformation'])->name('dashboard.businessInformation');
    Route::post('business-information', [DashboardController::class, 'businessInformationUpdate'])->name('dashboard.businessInformationUpdate');

    Route::get('change-number', [DashboardController::class, 'changeNumber'])->name('dashboard.changeNumber');
    Route::post('change-number', [DashboardController::class, 'numberUpdate'])->name('dashboard.numberUpdate');

    Route::get('change-email', [DashboardController::class, 'changeEmail'])->name('dashboard.changeEmail');
    Route::post('change-email', [DashboardController::class, 'emailUpdate'])->name('dashboard.emailUpdate');

    Route::get('disable-chats', [DashboardController::class, 'disableChats'])->name('dashboard.disableChats');
    Route::post('disable-chats', [DashboardController::class, 'chatsUpdate'])->name('dashboard.chatsUpdate');

    Route::get('disable-feedback', [DashboardController::class, 'disableFeedback'])->name('dashboard.disableFeedback');
    Route::post('disable-feedback', [DashboardController::class, 'feedbackUpdate'])->name('dashboard.feedbackUpdate');

    Route::get('manage-notification', [DashboardController::class, 'manageNotification'])->name('dashboard.manageNotification');
    Route::post('manage-notification', [DashboardController::class, 'manageNotificationUpdate'])->name('dashboard.manageNotificationUpdate');
    Route::post('mark-read-notification', [DashboardController::class, 'markReadNotification'])->name('dashboard.markReadNotification');
    Route::post('mark-all-as-read', [DashboardController::class, 'markAllAsRead'])->name('dashboard.markAllAsRead');

    Route::get('social-links', [DashboardController::class, 'socialLink'])->name('dashboard.socialLink');
    Route::post('social-links', [DashboardController::class, 'storeSocialLink'])->name('dashboard.storeSocialLink');

    Route::get('change-password', [DashboardController::class, 'changePassword'])->name('dashboard.changePassword');
    Route::post('new-password', [DashboardController::class, 'updatePassword'])->name('dashboard.updatePassword');
    
    Route::get('notifications', [DashboardController::class, 'notifications'])->name('dashboard.notifications');
    Route::post('notifications/read', [DashboardController::class, 'readNotifications'])->name('dashboard.readNotifications');

    Route::get('delete-account', [DashboardController::class, 'deleteAccount'])->name('dashboard.deleteAccount');
    Route::post('delete-account', [DashboardController::class, 'deleteAccountUpdate'])->name('dashboard.deleteAccountUpdate');

    Route::post('start-chat', [ChatController::class, 'start_chat'])->name('startChat');
    Route::post('chat/send-message', [ChatController::class, 'send_msg'])->name('sendMsg');
    Route::get('ajax-fetch-messages', [ChatController::class, 'fetch_messages'])->name('fetchChatMessages');
    Route::get('/fetch-chat-list', [ChatController::class, 'fetchChatList'])
    ->name('fetchChatList');
    
    // Vue.js API routes
    Route::get('api/chats', [ChatController::class, 'getChats'])->name('api.chats');
    Route::get('api/messages/{chat_id}', [ChatController::class, 'getMessages'])->name('api.messages');
    Route::post('api/send-message', [ChatController::class, 'sendMessage'])->name('api.sendMessage');
    Route::get('api/stickers', [ChatController::class, 'getStickers'])->name('api.stickers');

    Route::get('/dashboard/get-unread-chat-count', [DashboardController::class, 'getUnreadChatCount'])->name('dashboard.getUnreadChatCount');
});

Route::middleware('auth')->group(function () {
    Route::get('postAdd',[PostController::class, 'postAdd'])->name('postAdd');
    Route::post('check-duplicate-ad',[PostController::class, 'checkDuplicateAd'])->name('checkDuplicateAd');
    Route::post('add-ads',[PostController::class, 'addAds'])->name('addAds');
    Route::post('fetchCategory', [PostController::class, 'fetchCategory'])->name('fetchCategory');
    Route::get('fetchSubCategory', [PostController::class, 'fetchSubCategory'])->name('fetchSubCategory');
    Route::get('categoryModal', [PostController::class, 'categoryModal'])->name('categoryModal');
    Route::get('select_plantype',[PostController::class, 'select_plantype'])->name('select_plantype');
    Route::get('select_plan/{id}',[PostController::class, 'select_plan'])->name('select_plan');
    Route::post('plan/active',[PostController::class, 'plan_active'])->name('plan.active');
    // Route::post('plan/stripe-success',[PostController::class, 'stripe_success'])->name('plan.stripeSuccess');
    Route::get('/plan/success', [PostController::class, 'plan_success'])->name('planSuccess');
    Route::get('/ad-promotion-success', [PostController::class, 'adPromotionSuccess'])->name('adPromotionSuccess');
    Route::post('/create-promotion-intent', [PostController::class, 'createPromotionIntent'])->name('createPromotionIntent');
    Route::get('/stripe-payment-failed', [PostController::class, 'stripe_fail'])->name('stripeFail');
});

Route::post('addToList', [HomeController::class, 'addToList'])->name('addToList');
Route::post('myOffer', [HomeController::class, 'myOffer'])->name('myOffer');
Route::post('mainSearching', [HomeController::class, 'mainSearch'])->name('mainSearch');
Route::get('profile/{id}', [HomeController::class, 'profile'])->name('viewProfile');
Route::get('brands/{slug}', [HomeController::class, 'sellerpage'])->name('shop');
Route::post('careers', [HomeController::class, 'career'])->name('career');
Route::post('get-sub-cate', [HomeController::class, 'subCateHTML'])->name('subCateHTML');

Route::post('make-unavailable', [HomeController::class, 'makeUnavailable'])->name('makeUnavailable');
Route::post('make-report', [HomeController::class, 'makeReport'])->name('makeReport');
Route::post('report-abuse', [HomeController::class, 'ReportAbuse'])->name('ReportAbuse');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('categories/{any?}', [HomeController::class, 'categories'])->where('any', '.*');

Route::get('/blogs', [HomeController::class, 'blogs'])->name('blogsPage');
Route::get('/blog/{slug}', [HomeController::class, 'blog_detail'])->name('blogDetail');
Route::post('/blog/{id}/ajax-comment', [HomeController::class, 'blog_comment'])->name('blogComment');
Route::get('/album/{slug}', [HomeController::class, 'album_detail'])->name('albumDetail');
Route::get('/news', [HomeController::class, 'news'])->name('newsPage');
Route::get('/news/{slug}', [HomeController::class, 'news_detail'])->name('newsDetail');
Route::get('/events', [HomeController::class, 'events'])->name('eventsPage');
Route::get('/events/{slug}', [HomeController::class, 'events_detail'])->name('eventsDetail');
Route::post('/send-message', [HomeController::class, 'contact_mail'])->name('contactMail');
Route::post('/save-subscriber', [HomeController::class, 'subscribe'])->name('saveSubscriber');
Route::get('/{slug}', [HomeController::class, 'page'])->name('dynamicPage');
// Route::get('/{slug}/{sub?}/', [HomeController::class, 'page'])->name('dynamicPage');


// Broadcast::routes(); // Enables /broadcasting/auth route
// require base_path('routes/channels.php'); // Loads your private/public channels
