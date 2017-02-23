@extends('layouts.main')
@section('title')
@lang('home.titles.news')
@endsection
@section('content')

<div class="row">
    @include('article.sorted')
    @include('layouts.sidebar')
</div>
 
@endsection
