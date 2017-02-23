<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Image;
use App\Article;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //$files = Storage::files('paintings');
        $number_articles = 3;
        $number_quotes = 3;
        $entities = Article::getLastImageAndLatestArticlesAndQuotes($number_articles, 3);
        return view('home', [
            'image' => $entities->slice(0, 1)->get(0),
            'articles' => $entities->slice(1, $number_articles),
            'quotes' => $entities->slice($number_articles + 1, $number_quotes)]
        );
    }

    public function portfolio() {
        $count = 20;
        $entities = Image::getNumberOfImagesThumbnailsAndCategories(Image::$category_id, $count);
        $images = $entities->slice(0, $count);
        
        $files = [];
        foreach ($images as $image) {
            if (Storage::exists($image->title)) {
                $files[] = $image;
            }
        }
        
        return view('portfolio', ['images' => $files, 'categories' => $entities->slice(count($files))]);
    }

    public function blog() {
        return view('blog', ['articles' => Article::getAll()]);
    }

    public function games() {
        return view('games');
    }

    public function about() {
        return view('about');
    }

    public function contact() {
        return view('contact');
    }

    public function search(Request $request) {
        
    }

}
