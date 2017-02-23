<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Quote extends Model
{
    use ArticleImageTrait;
    
    protected $table = 'quotеs';

    protected static $parent;
    public static $category_id = 3;
    public function tags() {
        return $this->belongsToMany('App\Tag', 'quotes_tags');
    }
    
    public function category() {
        return $this->belongsTo('App\Category');
    }
    
    public static function getQuotes($category_id = null) {
        return DB::table('quotеs as q')
                ->select(
                'q.id', 
                'q.text', 
                'q.category_id',
                DB::raw('(SELECT name FROM category WHERE id=q.category_id) as category'),
                DB::raw('(SELECT GROUP_CONCAT(t.name) FROM tag as t JOIN quotes_tags as qt ON t.id=qt.tag_id JOIN quotеs as qu ON qt.quote_id=qu.id WHERE qt.quote_id=q.id) as tags'),
                'q.updated_at'
                )
                ->setBindings([$category_id])
                ->get();
    }
    
    public static function getRecord($id) {
        return DB::table('quotеs as q')
                ->select(
                'q.id', 
                'q.text', 
                'q.category_id',
                DB::raw('(SELECT GROUP_CONCAT(t.name) FROM tag as t JOIN quotes_tags as qt ON t.id=qt.tag_id JOIN quotеs as qu ON qt.quote_id=qu.id WHERE qt.quote_id=q.id) as tags'),
                'q.updated_at'
                )
                ->where('id', $id)
                ->get()
                ->first();
    }
    
}
