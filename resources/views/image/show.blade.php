@extends('layouts.main')
@section('title')
{{str_replace('-', ' ', $image->slug)}}
@endsection
@section('styles')
@parent
<link rel="stylesheet" href="/assets/css/image-preview.css"/>
@endsection
@section('content')
<dvi class="container">
    <div class="col-md-10">
        <h1 class="text-center image-heading orange">{{str_replace('-', ' ', $image->slug)}}</h1>
        <div style="background: rgba(11,11,11, .8)">
            <img class="img-responsive center-block" src="/storage/{{$image->src}}" style="max-width: 800px; max-height: 800px;"/>
            <button class="prev-next prev-button"></button>
            <button class="prev-next next-button"></button>
            
        </div>
        <div class="text-box">
            {!!$image->description!!}
        </div>
    </div>
    <div class="col-md-2">
        <div>
            <h5 class="text-center image-heading orange">@lang('home.headings.related')</h5>
            @foreach($related as $i)
            <a href="/image/{{$i->id}}/{{$i->slug}}">
                <img class="img-responsive" src="/storage/{{$i->src}}"/>
            </a>
            @endforeach
        </div>
        <br/>
        <div>
            <h5 class="text-center image-heading orange">@lang('home.headings.featured')</h5>
            @foreach($featured as $article)
            <a class="list-group-item" href="/article/{{$article->id}}/{{$article->slug}}">{{$article->name}}</a>
            @endforeach
        </div>
    </div>
</dvi>

@endsection
