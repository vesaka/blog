<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as Imager;

class Image extends Model {

    use ArticleImageTrait;

    protected static $image_dir = 'paintings/';
    protected static $thumbs_dir = 'thumbs/';
    protected $table = 'image';
    public static $category_id = 2;
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'area',
        'metadata',
        'extension',
        'created_at',
        'updated_at'
    ];

    public function tags() {
        return $this->belongsToMany('App\Tag', 'images_tags');
    }

    public function author() {
        return $this->belongsTo('App\User');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public static function upload(Image $image, $file = null) {

        $folderName = $image->category;

        $image_dir = Image::$image_dir . $folderName . '/';
        $thumbs_dir = Image::$thumbs_dir . $folderName . '/';

        if (!Storage::exists($image_dir)) {
            Storage::makeDirectory($image_dir, 777, true);
        }

        if (!Storage::exists($thumbs_dir)) {
            Storage::makeDirectory($thumbs_dir . 'small', 777, true);
            Storage::makeDirectory($thumbs_dir . 'large', 777, true);
        }

        $name = str_replace(' ', '_', $image->name) . $image->extension;

        Imager::make($file)->save(storage_path('app/' . $image_dir . $name));

        $cropData = json_decode($image->area);

        Imager::make(storage_path('app/' . $image_dir . $name))
                ->crop($cropData->width, $cropData->height, $cropData->x, $cropData->y)
                ->resize(1280, 720)
                ->save(storage_path('app/' . $thumbs_dir . 'large/' . $name))
        ;

        Imager::make(storage_path('app/' . $thumbs_dir . 'large/' . $name))
                ->resize(320, 180)
                ->save(storage_path('app/' . $thumbs_dir . 'small/' . $name));
    }

    public static function rename(Image $image) {
        $original = Image::$image_dir . $image->old_category . '/' . $image->oldname;
        $large = Image::$thumbs_dir . $image->old_category . '/large/' . $image->oldname;
        $small = Image::$thumbs_dir . $image->old_category . '/small/' . $image->oldname;

        $folderName = $image->category;
        $new_original = Image::$image_dir . $folderName . '/' . $image->name . $image->extension;
        $new_large = Image::$thumbs_dir . $folderName . '/large/' . $image->name . $image->extension;
        $new_small = Image::$thumbs_dir . $folderName . '/small/' . $image->name . $image->extension;

        if (Storage::exists($original)) {
            Storage::move($original, $new_original);
        } else {
            return;
        }

        $cropData = json_decode($image->area);
        if (Storage::exists($large)) {
            Storage::delete($large);
        }
        if (Storage::exists($small)) {
            Storage::delete($small);
        }
        Imager::make(storage_path('app/' . $new_original))
                ->crop($cropData->width, $cropData->height, $cropData->x, $cropData->y)
                ->resize(1280, 720)
                ->save(storage_path('app/' . $new_large));

        Imager::make(storage_path('app/' . $new_large))
                ->resize(320, 180)
                ->save(storage_path('app/' . $new_small));
    }

    public static function remove(Image $image) {
        $original = Image::$image_dir . $image->old_category . '/' . $image->oldname;
        $large = Image::$thumbs_dir . $image->old_category . '/large/' . $image->oldname;
        $small = Image::$thumbs_dir . $image->old_category . '/small/' . $image->oldname;

        Storage::delete([$original, $large, $small]);
    }

    public static function removeAll(Image $image) {

        $original = Image::$image_dir . $image->category . '/' . $image->name . $this->extension;
        $large = Image::$thumbs_dir . $image->category . '/large/' . $image->name . $this->extension;
        $small = Image::$thumbs_dir . $image->category . '/small/' . $image->name . $this->extension;

        Storage::delete([$original, $large, $small]);
    }

    public function getExtension($mimetype) {
        $extension = null;
        switch ($mimetype) {
            case 'image/jpeg':
            case 'image/jpg':
                $extension = '.jpg';
                break;
            case 'image/png':
                $extension = '.png';
                break;
            case 'image/gif':
                $extension = '.gif';
                break;
            default:
                break;
        }

        return $extension;
    }

    public static function getCategoryName(Image $image) {
        $category = Category::select('name')
                ->where('id', $image->category_id)
                ->get()
                ->toArray();

        return str_replace(' ', '_', $category[0]['name']);
    }
    
    public static function getRecord($id) {
        return Image::select(
                'image.id', 
                DB::raw('SUBSTR(image.name, 1, CHAR_LENGTH(image.name) - 11) as name'), 
                DB::raw('image.name as title'), 
                'image.description', 
                'image.area', 
                'image.metadata', 
                'image.extension', 
                'image.created_at', 
                'image.updated_at',
                'image.category_id as category',
                DB::raw('(SELECT GROUP_CONCAT(t.name) FROM tag as t JOIN images_tags as it ON t.id=it.tag_id JOIN image as i ON it.image_id=i.id WHERE i.id=?) as tags')
                        )
                        ->where('image.id', $id)
                        ->setBindings([$id, $id])
                        ->get()
                        ->first()
        ;
    }

    public function getRandomImage() {
        return Image::select(
                'id', 
                DB::raw('SUBSTR(name, 1, CHAR_LENGTH(name) - 11) as name'), 
                DB::raw('CONCAT(name, extension) as title'), 
                DB::raw('IF(LENGTH(description) > 128, CONCAT(SUBSTR(description, 1, 128), "..."), description) as title')
                        )
                        ->orderBy(DB::raw('RAND()'))
                        ->limit(1)
                        ->get()
                        ->first()
        ;
    }

    public static function getAll($size = 'large') {
        return DB::table('image as i')
                        ->select(
                                'i.id', 
                                DB::raw('(SELECT c.name FROM category as c WHERE c.id=i.category_id) as category'), 
                                DB::raw('REPLACE(SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11),"_"," ") as name'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as filename'), 
                                DB::raw('IF(LENGTH(i.description) > 128, CONCAT(SUBSTR(i.description, 1, 128), "..."), i.description) as description')
                        )
                        ->get()
        ;
    }

    public function getSortedImages() {
        return DB::table('image as i')
                        ->select(
                                'i.id', 
                                DB::raw('(SELECT c.name FROM category as c WHERE c.id=i.category_id) as category'), 
                                DB::raw('REPLACE(SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11),"_"," ") as name'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as filename'), 
                                DB::raw('IF(LENGTH(i.description) > 128, CONCAT(SUBSTR(i.description, 1, 128), "..."), i.description) as description')
                        )
                        ->get()
        ;
    }

    public static function getLatest($limit = 1) {
        return DB::table('image as i')
                        ->select(
                                'i.id', 
                                DB::raw('REPLACE(SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11),"_"," ") as name'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as filename'), 
                                DB::raw('IF(LENGTH(i.description) > 128, CONCAT(SUBSTR(i.description, 1, 128), "..."), i.description) as description')
                        )
                        ->orderBy('created_at', 'desc')
                        ->limit($limit)
                        ->get()
        ;
    }

    public function getImage($id) {
        return Image::select(
                'id', 
                DB::raw('SUBSTR(name, 1, CHAR_LENGTH(name) - 11) as name'), 
                DB::raw('CONCAT(name, extension) as title'), 
                DB::raw('IF(LENGTH(description) > 128, CONCAT(SUBSTR(description, 1, 128), "..."), description) as title')
                        )
                        ->where('id', $id)
                        ->get()
                        ->first()
        ;
    }

    public static function getNumberOfImagesAndThumbnails($limit = 10) {
        return DB::table('image as i')
                        ->select(
                                'i.id', 
                                'i.slug', 
                                DB::raw('SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11) as name'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as title'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/small/", i.name, i.extension) as thumb')
                        )
                        ->orderBy('i.created_at', 'desc')
                        ->limit($limit)
                        ->get();
    }
    
    public static function getNumberOfImagesAndThumbnailsByCategory($category_id, $limit = 10) {
        return DB::table('image as i')
                        ->select(
                                'i.id', 
                                'i.slug', 
                                DB::raw('SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11) as name'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as title'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/small/", i.name, i.extension) as thumb')
                        )
                        ->orderBy('i.created_at', 'desc')
                        ->where('i.category_id', $category_id)
                        ->limit($limit)
                        ->get();
    }

    public static function getNumberOfImagesThumbnailsAndCategories($id, $limit = 10) {
        return DB::table('image as i')
                        ->select(
                                'i.id', 
                                'i.slug', 
                                DB::raw('SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11) as name'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as title'), 
                                DB::raw('CONCAT("thumbs/", i.category_id, "/small/", i.name, i.extension) as thumb')
                        )
                        ->orderBy('i.created_at', 'desc')
                        ->limit($limit)
                        ->union(Category::select(
                                'id', DB::raw('NULL as slug'), 
                                DB::raw('REPLACE(name, "_", " ") as name'), 
                                DB::raw('NULL as title'), 
                                DB::raw('NULL as thumb'))->where('parent_id', $id))
                        ->get();
        
    }

    public static function getImageRelatedImagesAndLatestArticles($id) {
        return DB::table(DB::raw('(SELECT i.id, i.name, i.slug, i.description, i.category_id, i.created_at, i.updated_at, c.name as category, CONCAT("paintings/", i.category_id, "/", i.name, i.extension) as src FROM image as i LEFT JOIN category as c ON c.id=i.category_id WHERE i.id=?) as i'))
                ->select('i.id',
                        'i.src',
                        'i.name',
                        'i.slug',
                        'i.description', 
                        'i.created_at', 
                        'i.updated_at', 
                        'i.category',
                        DB::raw('(SELECT GROUP_CONCAT(t.name SEPARATOR " ") from tag as t INNER JOIN images_tags as it ON it.tag_id=t.id INNER JOIN image as im ON im.id=it.image_id WHERE im.id=i.id) as tags'))
                ->union(DB::table('image as i2')
                    ->select(
                            'i2.id',
                            DB::raw('CONCAT("thumbs/", i2.category_id, "/small/", i2.name, i2.extension) as src'),
                            'i2.name',
                            'i2.slug',
                            DB::raw('NULL as description'),
                            'i2.created_at', 
                            DB::raw('NULL as updated_at'), 
                            DB::raw('NULL as category'), 
                            DB::raw('NULL as tags')
                            )
                    ->where('i2.category_id', DB::raw('(SELECT category_id FROM image WHERE id=?)'))
                    ->where('i2.id', '!=', $id)
                    ->limit(3)
                 )
                ->union(Article::select(
                        'id', 
                        DB::raw('NULL as src'),
                        DB::raw('title as name'), 
                        'slug',
                        DB::raw('NULL as description'), 
                        'created_at', 
                        DB::raw('updated_at'),
                        DB::raw('NULL as category'),
                        DB::raw('NULL as tags')
                        )
                ->orderBy('created_at', 'desc')->limit(3))
                ->setBindings([$id, $id, $id])
                ->get()
                ;
                
                
    }
}
