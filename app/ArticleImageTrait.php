<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait ArticleImageTrait {

    public static function getAllCategoriesAsJSON() {
        return DB::table('category')
                        ->select('id', 'name as text', DB::raw('if(parent_id IS NULL ,"#",parent_id) as parent'))
                        ->get()
                        ->toJson();
    }

    public static function updateTagsAndReturnIds(array $tags) {
        $newTags = array_diff($tags, Tag::select('id', 'name')
                        ->whereIn('name', $tags)
                        ->pluck('name')
                        ->toArray()
        );

        if (!empty($newTags)) {
            $tagsToInsert = collect($newTags)->map(function($item) {
                return ['name' => $item];
            });
            Tag::insert($tagsToInsert->toArray());
            
        }

        return Tag::select('id')->whereIn('name', $tags)->pluck('id')->toArray();
    }

    public static function getTagsAndCategories() {
        return Tag::select(
                DB::raw('CONCAT("[", GROUP_CONCAT(CONCAT("\"", name, "\"")), "]") as tags'), 
                DB::raw('CONCAT("[", (SELECT GROUP_CONCAT("{\"id\":\"", id, "\",\"text\":\"", name, "\",\"parent\":\"", (IF(parent_id IS NULL ,"#",parent_id)), "\"}") FROM category), "]") as categories')
                        )
                        ->get()
                        ->first();
    }
    
    public static function getTagsAndCategoriesByParent($cat_id) {
        return Tag::select(
                DB::raw('CONCAT("[", GROUP_CONCAT(CONCAT("\"", name, "\"")), "]") as tags'), 
                DB::raw('CONCAT("[", (SELECT GROUP_CONCAT("{\"id\":\"", c1.id, "\",\"text\":\"", c1.name, "\",\"parent\":\"", (IF(c1.parent_id=? ,"#",c1.parent_id)), "\"}") FROM category as c1 LEFT JOIN category as c2 ON c1.parent_id=c2.id LEFT JOIN category as c3 ON c2.parent_id=c3.id LEFT JOIN category as c4 ON c3.parent_id=c4.id WHERE c1.parent_id=?), "]") as categories')
                        )
                        ->setBindings([$cat_id, $cat_id])
                        ->get()
                        ->first();
    }

    public static function getLatestImagesAndArticles($images_limit = 1, $articles_limit = 1) {
        $images = DB::table('image as i')
                ->select(
                        'i.id', 
                        DB::raw('REPLACE(SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11),"_"," ") as name'), 
                        DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as filename'), 
                        DB::raw('IF(LENGTH(i.description) > 128, CONCAT(SUBSTR(i.description, 1, 128), "..."), i.description) as description'), 
                        DB::raw('DATE_FORMAT(i.created_at, "%d %m %Y") as created_at')
                )
                ->orderBy('created_at', 'asc')
                ->limit($images_limit);

        $articles = DB::table('articles')
                ->select(
                        'id', 
                        DB::raw('title as name'), 
                        DB::raw('NULL as filename'), 
                        DB::raw('IF(LENGTH(text) > 90, CONCAT(SUBSTR(text, 1, 90), "..."), text) as description'), 
                        DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as created_at')
                )
                ->orderBy('created_at', 'asc')
                ->limit($articles_limit)
                ->union($images)
                ->get();

        return $articles;
    }

    public static function getLatestImagesArticlesAndQuotes($images_limit = 1, $articles_limit = 1, $quotеs_limit = 1) {
        $images = DB::table('image as i')
                ->select(
                        'i.id', 
                        'i.slug',
                        DB::raw('REPLACE(SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11),"_"," ") as name'), 
                        DB::raw('CONCAT("thumbs/", i.category_id, "/small/", i.name, i.extension) as filename'), 
                        DB::raw('IF(LENGTH(i.description) > 128, CONCAT(SUBSTR(i.description, 1, 128), "..."), i.description) as description'), 
                        DB::raw('DATE_FORMAT(i.created_at, "%d %m %Y") as posted_at')
                )
                ->orderBy('i.created_at', 'asc')
                ->limit($images_limit);

        $quotеs = DB::table('quotеs')
                ->select(
                        'id', 
                        DB::raw('NULL as slug'), 
                        DB::raw('NULL as name'), 
                        DB::raw('NULL as filename'), 
                        'text as description', 
                        DB::raw('DATE_FORMAT(created_at, "%d %m %Y") as posted_at'))
                ->orderBy('created_at', 'asc')
                ->limit($quotеs_limit);
        $articles = DB::table('articles')
                ->select(
                        'id', 
                        'slug', 
                        DB::raw('title as name'), 
                        DB::raw('NULL as filename'), 
                        DB::raw('IF(LENGTH(text) > 90, CONCAT(SUBSTR(text, 1, 90), "..."), text) as description'), 
                        DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as posted_at')
                )
                ->orderBy('created_at', 'desc')
                ->limit($articles_limit)
                ->union($images)
                ->union($quotеs)
                ->get();

        return $articles;
    }

    public static function getLastImageAndLatestArticlesAndQuotes($articles_limit = 1, $quotеs_limit = 1) {
        $articles = DB::table('articles')
                ->select(
                        'id', 
                        DB::raw('title as name'), 
                        'slug', 
                        DB::raw('NULL as filename'), 
                        DB::raw('IF(LENGTH(text) > 90, CONCAT(SUBSTR(text, 1, 90), "..."), text) as description'), 
                        DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as posted_at')
                )
                ->orderBy('created_at', 'desc')
                ->limit($articles_limit);
        $quotes = DB::table('quotеs')
                ->select('id', 
                        DB::raw('NULL as name'), 
                        DB::raw('NULL as slug'), 
                        DB::raw('NULL as filename'), 'text as description', 
                        DB::raw('DATE_FORMAT(created_at, "%d %m %Y") as posted_at'))
                ->orderBy('created_at', 'desc')
                ->limit($quotеs_limit);

        return DB::table('image as i')
                ->select('i.id', DB::raw('REPLACE(SUBSTR(i.name, 1, CHAR_LENGTH(i.name) - 11),"_"," ") as name'), 'i.slug', DB::raw('CONCAT("thumbs/", i.category_id, "/large/", i.name, i.extension) as filename'), DB::raw('IF(LENGTH(i.description) > 128, CONCAT(SUBSTR(i.description, 1, 128), "..."), i.description) as description'), DB::raw('DATE_FORMAT(i.created_at, "%d %m %Y") as posted_at'))
                        ->orderBy('i.created_at', 'asc')
                        ->limit(1)
                        ->union($articles)
                        ->union($quotes)
                        ->get();
    }

    
    
}
