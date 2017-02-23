<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        
        $categories = Category::select(
                        'id', DB::raw('REPLACE(name, "_", " ") as text'), DB::raw('if(parent_id IS NULL ,"#",parent_id) as parent')
                )
                ->get()
                ->toJson();
        return view('category.list', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'category_name' => 'required|regex:/^[a-zA-Z\-_\s+\d]+$/|min:3'
                ], [
            'category_name.required' => 'Няма име за категория!',
            'category_name.regex' => 'Недопустими символи в името за категория!',
            'category_name.min' => 'Категорията трябва да е поне 3 символа!'
        ]);
        $parent_id = $request->get('category_id');
        $category = new Category();
        $category->name = str_replace(' ', '_', $request->get('category_name'));
        $category->parent_id = $parent_id ? $parent_id : null;
        $category->save();


        return response()->json(Category::getAll(), 200);
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
            'category_id' => 'required',
            'category_name' => 'required|regex:/^[a-zA-Z\-_\s+\d]+$/|min:3'
                ], [
            'category_id.required' => 'Не е посочена категория!',
            'category_name.required' => 'Няма име за категория!',
            'category_name.regex' => 'Недопустими символи в името за категория!',
            'category_name.min' => 'Категорията трябва да е поне 3 символа!',
        ]);
        $category = Category::find($id);
        $category->name = str_replace(' ', '_', $request->get('category_name'));
        $category->save();

        return response()->json(Category::getAll(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if ($id != 0) {
            Category::find($id)->delete();
        }
        return response()->json(Category::getAll(), 200);
    }

}
