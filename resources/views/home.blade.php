@extends('layouts.main')

@section('title')
@lang('home.titles.start')
@endsection

@section('scripts')
@parent
<script src="/assets/js/jssor.slider.-22.1.8.min.js"></script>
@endsection

@section('styles')
@parent
<link rel="stylesheet" href="/assets/css/slider-styles.css"/>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <h1 class="title-heading orange image-heading">@lang('home.titles.start')</h1>
    </div>
    <div class="row">
        <div class="col-lg-7 text-center transparent-bg">
            <a href="/image/{{$image->id}}/{{$image->slug}}">
                <h3 class="heading-image orange">{{$image->name}}</h3>
                <img class="img-responsive" src="/storage/{{$image->filename}}" alt="{{$image->name}}" class="height-360"/>
            </a>
        </div>
        <div class="col-lg-5 panel panel-default orange height-360">
            <div class="panel-heading">
                <span class="lead text-primary"><b>@lang('home.info.latest_articles')</b></span>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    @foreach($articles as $article)
                    <li class="list-group-item feed">
                        <a class="col-sm-12 article-title" href="/article/{{$article->id}}/{{$article->slug}}">{{$article->name}}</a>
                        <div class="article-date text-right">
                            <span class="text-gray date-post">
                                <i class="fa fa-calendar"></i>
                                <small class="col-sm-push-6"><em>{{$article->posted_at}}</em></small>
                            </span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <h3 class="title-heading orange image-heading"><b>@lang('home.info.latest_quotes')</b></h3>
        <div class="col-md-12 well">
            @foreach($quotes as $quote)
            <div class="col-lg-4 panel panel-body" style="height: 12em;">
                <div class="quote-body">
                    <p></i>{!!$quote->description!!}</p>
                    <span class="date-post">
                        <i class="fa fa-calendar"></i>
                        <small><em>{{$article->posted_at}}</em></small>
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="row well skills transparent-bg">
        <div class="col-md-4 well">
            <a class="btn btn-default" href="/about">
                <img src="/assets/img/code_small.jpg" alt="@lang('home.info.developer.heading')" class="img-circle"/>
            </a>
            <h3 class="panel panel-success panel-heading">@lang('home.info.developer.heading')</h3>
            <p>@lang('home.info.developer.text')</p>
            <a class="btn btn-default" href="#">@lang('home.info.more_info')</a>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-4 well">
            <a class="btn btn-default" href="/portfolio">
                <img src="/assets/img/bamboo_fun_small.jpg" alt="@lang('home.info.artist.heading')" class="img-circle"/>
            </a>
            <h3 class="panel panel-success panel-heading">@lang('home.info.artist.heading')</h3>
            <p>@lang('home.info.artist.text')</p>
            <a class="btn btn-default" href="#">@lang('home.info.more_info')</a>
        </div>
        <!-- /.col-md-4 -->
        <div class="col-md-4 well">
            <a class="btn btn-default" href="/games">
                <img src="/assets/img/controller-100.png" alt="@lang('home.info.game_dev.heading')" class="img-circle"/>
            </a>   
            <h3 class="panel panel-success panel-heading">@lang('home.info.game_dev.heading')</h3>
            <p>@lang('home.info.game_dev.text')</p>
            <a class="btn btn-default" href="/games">@lang('home.info.more_info')</a>
        </div>
    </div>
</div>
@endsection
