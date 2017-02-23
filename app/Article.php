<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model {

    use ArticleImageTrait;

    protected $table = 'articles';
    public static $category_id = 1;
    public function tags() {
        return $this->belongsToMany('App\Tag', 'articles_tags');
    }

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public static function getAll() {
        
        $articles = DB::table('articles as a')
                        ->select(
                        'a.id', 'a.title', 'a.text', 'a.created_at', 'a.updated_at',
                        DB::raw('(SELECT c.name FROM category as c WHERE c.id=a.id) as category'),
                        DB::raw('(SELECT GROUP_CONCAT(t.name) FROM tag as t '
                                . 'INNER JOIN articles_tags as at ON t.id=at.tag_id '
                                . 'INNER JOIN articles as ar ON ar.id=at.article_id WHERE ar.id=a.id) as tags')
                )
                ->get();
        
        return $articles;
    }

    public static function getLatest($limit = 1) {
        
    }
}
