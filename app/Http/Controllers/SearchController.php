<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function findArticlesByCategory($category_id) {
        $articles = Article::select(
                'id', 
                'title',
                'text'
                )
                ->where('category_id', $category_id)
                ->get();
        
        return response()->view('article.sorted', ['articles' => $articles]);
    }
}
