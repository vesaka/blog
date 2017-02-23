<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('article.list', ['articles' => Article::select('id', 'title', 'updated_at', 'created_at')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('article.form', ['categories' => \App\Category::getByParent(Article::$category_id), 'tags' => json_encode(\App\Tag::pluck('name')->toArray())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'article_title' => 'required|min:3|regex:/^[a-zа-я;\.,\-\s]+$/iu',
            'article_category' => 'required',
            'article_description' => 'required|max:100000'
        ]);

        $article = new Article();
        $article->slug = str_replace(' ', '-', preg_replace('/[^a-zа-я\d\s]+/iu', '', $request->get('article_title')));
        $article->title = $request->get('article_title');
        $article->text = $request->get('article_description');
        $article->category_id = $request->get('article_category');
        $article->save();
        $tags = explode(',', str_replace(' ', '', $request->get('article_tags')));

        $ids = Article::updateTagsAndReturnIds($tags);
        $article->tags()->sync($ids);
        return redirect()->action('ArticleController@edit', ['id' => $article->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $article = Article::find($id);
        $article->tags = implode(',', $article->tags()->pluck('name')->toArray());
        return view('article.form', ['article' => $article,
            'categories' => Article::getAllCategoriesAsJSON(),
            'tags' => json_encode(\App\Tag::pluck('name')->toArray())
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'article_title' => 'required|min:3|regex:/^[a-zа-я;\.,\-\s]+$/iu',
            'article_category' => 'required',
            'article_description' => 'required|max:100000'
        ]);

        $article = Article::find($id);
        $article->slug = str_replace(' ', '-', preg_replace('/[^a-zа-я\d\s]+/iu', '', $request->get('article_title')));
        dd($article->slug);
        $article->title = $request->get('article_title');
        $article->text = $request->get('article_description');
        $article->category_id = $request->get('article_category');
        $article->save();
        $tags = explode(',', str_replace('\s+', ' ', $request->get('article_tags')));

        $ids = Article::updateTagsAndReturnIds($tags);
        $article->tags()->sync($ids);
        return redirect()->action('ArticleController@edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $article = Article::find($id);
        $article->tags()->detach();
        $article->delete();

        return redirect()->action('ArticleController@index');
    }

}
