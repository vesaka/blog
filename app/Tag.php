<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tag';
    
    protected $fillable = ['name'];
    public function images() {
        return $this->belongsToMany('App\Image', 'images_tags');
    }
    
    public function articles() {
        return $this->belongsToMany('App\Article', 'articles_tags');
    }
    
    public function quotes() {
        return $this->belongsToMany('App\Quote', 'quotes_tags');
    }
}
