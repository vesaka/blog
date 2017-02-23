<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> @section('title'){{ config('app.name', 'Laravel') }}@show</title>

        <!-- Styles -->

        @section('styles')

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,400">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Droid+Sans">
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster">
        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/style.css">


        <!-- Favicon and touch icons -->
        <link rel="apple-touch-icon" sizes="57x57" href="/ico/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/ico/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/ico/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/ico/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/ico/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/ico/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/ico/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/ico/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/ico/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/ico/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/ico/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/ico/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/ico/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <link href="https://fonts.googleapis.com/css?family=Fjalla+One|Lobster" rel="stylesheet"> 
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ico/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        @show

        @section('scripts')
        <script src="/components/jquery/jquery.min.js"></script>
        <script src="/components/bootstrap/js/bootstrap.min.js"></script>
        @show
    </head>
    <body style="background-image: url(/assets/img/pattern6.jpg);  background-attachment: fixed;">
        <!-- Header -->
        <nav class="navbar navbar-inverse" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/"><img src="/images/logo1.svg" class="brand-logo" style="max-width: 128px; margin-top: 10px;"/></a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse pull-right header" id="bs-example-navbar-collapse-1">
                    <ul id="my-navbar" class="nav navbar-nav">
                        <li class="localizations">
                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                <abbr title="{{ $properties['native'] }}">
                                    <div class="locale locale-{{strtolower($localeCode)}}"></div>
                                </abbr>
                            </a>
                            @endforeach
                        </li>

                        <li id="home-item">
                            <a href="/home" class="navbar-menu-item"><i class="fa fa-home fa-2x"></i><br />@lang('home.menu.home')</a>
                        </li>
                        <li>
                            <a href="/portfolio" class="navbar-menu-item"><i class="fa fa-picture-o fa-2x"></i><br />@lang('home.menu.portfolio')</a>
                        </li>
                        <li>
                            <a href="/games" class="navbar-menu-item"><i class="fa fa-gamepad fa-2x"></i><br />@lang('home.menu.games')</a>
                        </li>
                        <li>
                            <a href="/blog" class="navbar-menu-item"><i class="fa fa-comment-o fa-2x"></i><br />@lang('home.menu.blog')</a>
                        </li>
                        <li>
                            <a href="/about" class="navbar-menu-item"><i class="fa fa-info fa-2x"></i><br />@lang('home.menu.about')</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 widget span3">
                        <p><i class="fa fa-user"></i> @lang('home.footer.skype'): vesaka_bgr</p>
                        <p><i class="fa fa-envelope-o"></i> @lang('home.footer.email'): <a href="">vesakabgr@gmail.com</a></p>
                    </div>
                    <div class="col-lg-4 copyright span4">|&nbsp;
                        <a href="/blog">@lang('home.menu.blog')</a>&nbsp;|&nbsp;
                        <a href="/portfolio">@lang('home.menu.portfolio')</a>&nbsp;|&nbsp;
                        <a href="/games">@lang('home.menu.games')</a>&nbsp;|&nbsp;
                        <a href="/about">@lang('home.menu.about')</a>&nbsp;|&nbsp;
                    </div>
                    <div class="col-lg-4 social span8">
                        <div class="row">
                            <a class="fa fa-facebook-square fa-3x text-left" href="https://www.facebook.com/VesakaArtAndCreation/"></a>
                            <a class="fa fa-twitter-square fa-3x text-left" href="https://twitter.com/VeselinGenkov"></a>
                            <a class="fa fa-google-plus-square fa-3x text-left" href=""></a>
                            <a class="fa fa-twitch fa-3x text-left" href=""></a>
                            <a class="fa fa-instagram fa-3x text-left" href=""></a><br/><br/>
                            <a class="fa fa-tumblr-square fa-3x text-left" href=""></a>
                            <a class="fa fa-github-square fa-3x text-left" href=""></a>
                            <a class="fa fa-deviantart fa-3x text-left" href=""></a>
                            <a class="fa fa-youtube-square fa-3x text-left" href=""></a>
                            <a class="fa fa-steam-square fa-3x text-left" href=""></a>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="row text-center">
                    <p>@lang('home.footer.copyright'). Template by <a href="http://azmind.com">Azmind</a>.</p>
                </div>
            </div>
        </footer>        
        <!-- Javascript -->
        <script src="/js/jquery.flagstrap.min.js"></script>
        <script>
$(document).ready(function () {

    var url = window.location.href;
    var APP_URL = {!! json_encode(url('/')) !!} + '/';
    if (url.length > APP_URL.length) {
        $('#my-navbar li a.navbar-menu-item').each(function (index) {
            
            var href = this.href + '/' + '{{ LaravelLocalization::getCurrentLocale() }}';
            if (this.href.substr(APP_URL.length) === url.substr(APP_URL.length + 3)) {
                $(this).parent().addClass('current-page');                
            }
        });
    } else {
        $('#home-item').addClass('current-page');
    }
    var locale = "{{ LaravelLocalization::getCurrentLocale() }}";
    $('#select_country').attr('data-selected-country', locale);
});

        </script>
    </body>
</html>


