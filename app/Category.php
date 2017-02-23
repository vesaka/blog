<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Category extends Model
{
    protected $table = 'category';
    public function articles() {
        return $this->hasMany('App\Article');
    }
    
    public function images() {
        return $this->hasMany('App\Image');
    }
    
    public function children() {
        return $this->hasMany('App\Category');
    }
    
    public function parent() {
        return $this->belongsTo('App\Category');
    }
    
    public static function getAllAsJson() {
        return Category::select('id', DB::raw('REPLACE(name, "_", " ") as text'), DB::raw('if(parent_id IS NULL ,"#",parent_id) as parent'))
                        ->get()
                        ->toJson();
    }
    
    public static function getAll() {
        return Category::select('id', DB::raw('REPLACE(name, "_", " ") as text'), DB::raw('if(parent_id IS NULL ,"#",parent_id) as parent'))
                        ->get()
                        ->toArray();
    }
    
    public static function getByParent($id) {
        return DB::table('category as c1')->select('c1.id as id', DB::raw('REPLACE(c1.name, "_", " ") as text'), DB::raw('if(c1.parent_id=? ,"#",c1.parent_id) as parent'))
                        ->leftJoin('category as c2', 'c1.parent_id', '=', 'c2.id')
                        ->leftJoin('category as c3', 'c2.parent_id', '=', 'c3.id')
                        ->leftJoin('category as c4', 'c3.parent_id', '=', 'c4.id')
                        ->where('c1.parent_id', $id)
                        ->setBindings([$id, $id])
                        ->get()
                        ->toJson();
    }
    
    public static function getChildrenByParent($id) {
        return Category::select('id', DB::raw('REPLACE(name, "_", " ")'))
                        ->where('parent_id', $id)
                        ->get()
                        ->toArray();
    }
}
