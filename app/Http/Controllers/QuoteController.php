<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quote;

class QuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Quote::getTagsAndCategoriesByParent(Quote::$category_id);
        return view('quote.index', ['quotes' => Quote::getQuotes(), 'categories' => $data->categories, 'tags' => $data->tags]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
           'quote_text' => 'min:3',
           'quote_category' => 'required'
        ], [
           'quote_category.required' => 'Не е посочена категория!'
        ]);
        $quote = new Quote();
        $quote->text = $request->get('quote_text');
        $quote->category_id = $request->get('quote_category');
        $quote->save();
        $tags = explode(',', str_replace('\s+', ' ', $request->get('quote_tags')));
        
        $ids = Quote::updateTagsAndReturnIds($tags);
        $quote->tags()->attach($ids);
        
        return response()->view('quote.list', ['quotes' => Quote::getQuotes()], 200);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Quote::getRecord($id), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $quote = Quote::getRecord($id);
        return response()->json($quote, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
           'quote_text' => 'min:3',
           'quote_id' => 'required',
           'quote_category' => 'required'
        ], [
           'quote_id.required' => 'Не е избран цитат!',
           'quote_category.required' => 'Не е посочена категория!'
        ]);
        
        $quote = Quote::find($id);
        $quote->text = $request->get('quote_text');
        $quote->category_id = $request->get('quote_category');
        $quote->save();
        $tags = explode(',', str_replace('\s+', ' ', $request->get('quote_tags')));
        
        $ids = Quote::updateTagsAndReturnIds($tags);
        $quote->tags()->sync($ids);
        
        return response()->view('quote.list', ['quotes' => Quote::getQuotes(), 'success' => 'Успешно добавяне'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quote = Quote::find($id);
        $message = 'Грешка при изтриването!';
        if ($quote) {
            $quote->tags()->detach();
            $quote->delete();
            $message = 'Успешно изтриване!';
        }
        
        return response()->view('quote.list', ['quotes' => Quote::getQuotes(), 'success' => $message], 200);
    }
}
