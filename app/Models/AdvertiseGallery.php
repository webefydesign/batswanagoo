<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdvertiseGallery extends Model
{
    use SoftDeletes;

    protected $table = 'advertise_gallery';
    protected $fillable = ['adv_id', 'image', 'ext', 'thumb_img', 'mobile_img', 'medium_img'];

    /**
     * Two-line text watermark across the center of the image:
     * "POSTED ON SALONE GOO" above the poster's name, both semi-transparent
     * white - matching the reference design. Applied only to the
     * large/original image - the one actually shown in the lightbox/detail
     * view - so the small grid thumbnails stay clean.
     *
     * Needs a real TTF/OTF font file at public/fonts/watermark.ttf - GD
     * (the image driver in use here) can only draw text from an actual
     * font file, and none ships with this project or Intervention Image.
     * If the file isn't there, this silently no-ops (logging why) instead
     * of breaking the upload. Drop a font you have rights to redistribute
     * (e.g. a Google Fonts Bold weight, which are all open-licensed) at
     * that path to turn the watermark on.
     */
    private static function applyWatermark($image, $posterName = null)
    {
        $fontPath = public_path('fonts/watermark.ttf');
        if (!file_exists($fontPath)) {
            \Log::info('Watermark skipped: font file missing at ' . $fontPath);
            return $image;
        }

        try {
            $width = $image->width();
            $height = $image->height();
            $centerX = (int) round($width / 2);
            $centerY = (int) round($height / 2);

            // Sizes scale with image width so this looks right on any photo.
            $topSize = max(12, (int) round($width * 0.03));
            $nameSize = max(18, (int) round($width * 0.05));
            $lineGap = (int) round($nameSize * 0.4);

            $image->text('POSTED ON SALONE GOO', $centerX, $centerY - $lineGap, function ($font) use ($fontPath, $topSize) {
                $font->filename($fontPath);
                $font->size($topSize);
                $font->color('#ffffff47'); // white, ~70% opacity
                $font->align('center');
                $font->valign('middle');
            });

            $posterName = trim((string) $posterName);
            if ($posterName !== '') {
                $image->text(mb_strtoupper($posterName), $centerX, $centerY + $lineGap, function ($font) use ($fontPath, $nameSize) {
                    $font->filename($fontPath);
                    $font->size($nameSize);
                    $font->color('#ffffff63'); // white, ~80% opacity
                    $font->align('center');
                    $font->valign('middle');
                });
            }
        } catch (\Exception $e) {
            \Log::info('Watermark failed: ' . $e->getMessage());
        }

        return $image;
    }

    /**
     * The name shown in the watermark: the account's `name` field, falling
     * back to first_name + last_name when `name` is blank.
     */
    private static function resolvePosterName($user)
    {
        if (!$user) {
            return null;
        }

        if (!empty($user->name)) {
            return $user->name;
        }

        return trim(($user->first_name ?? '').' '.($user->last_name ?? ''));
    }

    public static function creator($images, $adv){
        $id = $adv->id;
        $posterName = self::resolvePosterName($adv->user);

        /* Make Images Directory */
        $p_img = public_path().'/uploads/post/';
        File::isDirectory($p_img) or File::makeDirectory($p_img, 0777, true, true);
    
        $uploadDir = public_path('uploads/post');
    
        if(!File::exists($uploadDir.'/'.$id)){
            File::makeDirectory($uploadDir.'/'.$id, 0775);
        }
        $uploadDir = $uploadDir.'/'.$id;
    
        foreach($images as $file){
            if($file != null){
                $ext = $file->getClientOriginalExtension();
                $name = rand(0, 999999).'_'.time().'.'.$ext;
    
                // Create image manager
                $manager = new ImageManager(new Driver());
    
                // 1. ORIGINAL/LARGE - For lightbox/single item view (max 1200px width, high quality)
                $original = $manager->read($file);
                $original->scaleDown(width: 1200); // Max width 1200px, keeps aspect ratio
                self::applyWatermark($original, $posterName);
                $original->save($uploadDir.'/'.$name, 85); // 85% quality
    
                // 2. MEDIUM - For desktop grid view (250px width, aspect ratio maintained)
                $medium = $manager->read($file);
                $medium->scaleDown(width: 250); // Exactly 250px width, auto height
                $medium->save($uploadDir.'/medium_'.$name, 80); // 80% quality
    
                // 3. MOBILE - For mobile devices (500px width for retina, aspect ratio)
                $mobile = $manager->read($file);
                $mobile->scaleDown(width: 500); // 500px for retina displays
                $mobile->save($uploadDir.'/mobile_'.$name, 75); // 75% quality
    
                // 4. THUMBNAIL - For small previews (100px width)
                $thumb = $manager->read($file);
                $thumb->scaleDown(width: 100);
                $thumb->save($uploadDir.'/thumb_'.$name, 70); // 70% quality
    
                $img = [
                    'image' => $id.'/'.$name,              // Original/Large
                    'medium_img' => $id.'/medium_'.$name,  // Desktop grid (250px)
                    'mobile_img' => $id.'/mobile_'.$name,  // Mobile view (500px)
                    'thumb_img' => $id.'/thumb_'.$name,    // Thumbnail (100px)
                    'ext' => $ext,
                    'adv_id' => $id
                ];
                
                AdvertiseGallery::create($img);
            }
        }
    }
    
    public static function updator($request, $adv)
    {
        $id = $adv->id;
        $posterName = self::resolvePosterName($adv->user);

        $p_img = public_path('/uploads/post/');
        File::isDirectory($p_img) or File::makeDirectory($p_img, 0777, true, true);

        $uploadDir = public_path('uploads/post/' . $id);

        $manager = new ImageManager(new Driver());

        /*
        --------------------------------
        DELETE REMOVED IMAGES
        --------------------------------
        */
        if ($request->deleted_images) {

            $deleted = json_decode($request->deleted_images, true);

            foreach ($deleted as $img_id) {

                $ai = AdvertiseGallery::find($img_id);

                if ($ai) {
                    File::delete([
                        public_path('uploads/post/'.$ai->image),
                        public_path('uploads/post/'.$ai->medium_img),
                        public_path('uploads/post/'.$ai->mobile_img),
                        public_path('uploads/post/'.$ai->thumb_img),
                    ]);

                    $ai->delete();
                }
            }
        }

        /*
        --------------------------------
        ADD NEW IMAGES
        --------------------------------
        */
        if ($request->file('images')) {

            foreach ($request->file('images') as $file) {

                if (!$file) continue;

                $ext = $file->getClientOriginalExtension();
                $name = rand(0, 999999) . '_' . time() . '.' . $ext;

                // ORIGINAL
                $original = $manager->read($file);
                $original->scaleDown(width: 1200);
                self::applyWatermark($original, $posterName);
                $original->save($uploadDir.'/'.$name, 85);

                // MEDIUM
                $medium = $manager->read($file);
                $medium->scaleDown(width: 250);
                $medium->save($uploadDir.'/medium_'.$name, 80);

                // MOBILE
                $mobile = $manager->read($file);
                $mobile->scaleDown(width: 500);
                $mobile->save($uploadDir.'/mobile_'.$name, 75);

                // THUMB
                $thumb = $manager->read($file);
                $thumb->scaleDown(width: 100);
                $thumb->save($uploadDir.'/thumb_'.$name, 70);

                AdvertiseGallery::create([
                    'image' => $id.'/'.$name,
                    'medium_img' => $id.'/medium_'.$name,
                    'mobile_img' => $id.'/mobile_'.$name,
                    'thumb_img' => $id.'/thumb_'.$name,
                    'ext' => $ext,
                    'adv_id' => $id
                ]);
            }
        }
    }


}
