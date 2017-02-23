<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Image;

class ImageController extends Controller {

    protected $table = 'image';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {       
        $images = DB::table('image as i')
                ->select(
                    'i.id',
                    DB::raw('CONCAT("/storage/thumbs/", i.category_id, "/large/", name, extension) as filepath')
                )
                ->get();
        return view('image.list', ['images' => $images]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('image.form', ['categories' => \App\Category::getByParent(Image::$category_id), 'tags' => json_encode(\App\Tag::pluck('name')->toArray())]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {

        $image = $this->createModel($request);
        $tags = explode(',', str_replace(' ', '', strtolower($request->get('image_tags'))));
        $ids = Image::updateTagsAndReturnIds($tags);
        $image->category = $image->category_id;
        $image->tags()->sync($ids);

        Image::upload($image, $request->file('image_file'));
        //return redirect()->action('ImageController@edit', ['id' => $image->id]);
        return redirect()->action('ImageController@create', ['id' => $image->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $image = Image::find($id);
        $image->tags = implode(',', $image->tags()->pluck('name')->toArray());
        $image->src = '/storage/paintings/' . $image->category . '/' . $image->name. $image->extension;
        return view('image.show', ['image' => $image]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        
        $image = Image::getRecord($id);
        $image->src = '/storage/paintings/' . $image->category . '/' . $image->title . $image->extension;        
        $image->name = trim(str_replace('_', ' ', $image->name));
        
        return view('image.form', [
            'image' => $image,
            'categories' => \App\Category::getByParent(Image::$category_id),
            'tags' => json_encode(\App\Tag::pluck('name')->toArray())]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        
        $image = $this->createModel($request, $id);
        
        $tags = explode(',', str_replace(' ', '', strtolower($request->get('image_tags'))));
        $ids = Image::updateTagsAndReturnIds($tags);
        $image->category = $image->category_id;
        $image->tags()->sync($ids);
        
        $hasFile = $request->hasFile('image_file');
        if ($hasFile) {
            Image::remove($image);
            Image::upload($image, $request->file('image_file'));
        } else {
            Image::rename($image);
        }
        
        return redirect()->action('ImageController@edit', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $image = Image::getRecord($id);
        Image::removeAll($image);
        $image->tags()->detach();
        $image->delete();
        
        return redirect()->action('ImageController@index');
        
    }

    private function createModel(Request $request, $id = null) {

        $this->validate($request, [
            'image_title' => 'required|min:3|regex:/^[A-Za-z. -_]+$/',
            'image_category' => 'required',
            'image_description' => 'required|max:100000',
        ]);

        if ($id !== null) {
            $image = Image::getRecord($id);
            $oldname = $image->title . $image->extension;
            $old_category = $image->category;
        } else {
            $image = new Image();
        }
        
        $image->slug = preg_replace('/[^a-z\d]+/i', '', $request->get('image_title'));
        $image->name = str_replace(' ', '_', $request->get('image_title')) . '_' . time();
        $image->description = $request->get('image_description');
        $image->category_id = $request->get('image_category');
        $image->area = $request->get('image_crop_data');
        $image->metadata = $request->get('image_metadata');
        if ($request->hasFile('image_file')) {
            $image->extension = $image->getExtension($request->file('image_file')->getMimeType());
        }
        $image->save(); 
        if ($id !== null) {
            $image->oldname = $oldname;
            $image->old_category = $old_category;
        }
        
        return $image;
    }
    
    public function getAll() {
        return response()->view('image.slider', ['images' => Image::getNumberOfImagesAndThumbnails()]);
    }
    
    public function getImagesBy($category_id) {
        return response()->view('image.slider', ['images' => Image::getNumberOfImagesAndThumbnailsByCategory($category_id)]);
    }
    
    public function getImageAndFeaturedEntites($id, $name) {
        $entities = Image::getImageRelatedImagesAndLatestArticles($id);
        
        return view('image.show', ['image' => $entities->slice(0, 1)->get(0), 'related' => $entities->slice(1, 3), 'featured' => $entities->slice(4, 3)]);
    }

}
