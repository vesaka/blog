<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <link rel="stylesheet" href="/_admin/css/jquery-ui.min.css">
        <link rel="stylesheet" href="/_admin/css/font-awesome.min.css">
        <link rel="stylesheet" href="/_admin/css/bootstrap.min.css">
        <link rel="stylesheet" href="/_admin/css/cropper.min.css">
        <link rel="stylesheet" href="/_admin/css/cropper-main.css">
        <link rel="stylesheet" href="/_admin/libs/jstree/themes/default/style.min.css">
        <link rel="stylesheet" href="/_admin/css/bootstrap-tokenfield.min.css">
        <link rel="stylesheet" href="/_admin/css/tokenfield-typeahead.min.css">        
        <link rel="stylesheet" href="/_admin/css/sidebar.css"/>
        <link rel="stylesheet" href="/_admin/css/main.css"/>
        <link rel="stylesheet" href="/_admin/css/thumbnail-gallery.css"/>
        <script src="/_admin/js/jquery-3.0.0.js"></script>
        <!-- Scripts -->
        <script>
            window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        <script src="/_admin/js/jquery-ui.min.js"></script>
        <script src="/_admin/js/bootstrap.min.js"></script>
        <script src="/_admin/libs/tinymce/tinymce.min.js"></script>
        <script src="/_admin/js/bootstrap-tokenfield.min.js"></script>
        <script src="/_admin/libs/jstree/jstree.min.js"></script>
        <script src="/_admin/js/cropper.min.js"></script>
        <script src="/_admin/js/validator.js"></script>

    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-fixed-top navbar-custom">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->
                            @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                            @else
                            <li class="dropdown">
                                
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="glyphicon glyphicon-user"></i>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                
                                <ul class="dropdown-menu" role="menu">
                                    
                                    <li>
                                        
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class="nav-side-menu col-md-2">
                    <div class="brand">Admin Panel</div>
                    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

                    <div class="menu-list">
                        <ul id="menu-content" class="menu-content collapse out">
                            <li>
                                <a href="{{url('admin')}}" data-model="home" class="d-block" onclick="Model.getPage(event)">
                                    <i class="glyphicon glyphicon-home"></i> Начало
                                </a>
                            </li>

                            <li data-toggle="collapse" data-target="#countries">
                                <a href="{{url('admin/image')}}"  class="d-block" data-model="country" onclick="navigation.getPage(event)">
                                    <i class="glyphicon glyphicon-picture"></i> Изображения
                                </a>
                            </li>  
                            <li>
                                <a href="{{url('/admin/article')}}" class="d-block" data-model="team" onclick="navigation.getPage(event)">
                                    <i class="glyphicon glyphicon-list-alt"></i> Статии 
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/admin/quote')}}" class="d-block" data-model="team" onclick="navigation.getPage(event)">
                                    <i class="glyphicon glyphicon-bullhorn"></i> Цитати 
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/admin/category')}}" class="d-block" onclick="navigation.getPage()">
                                    <i class="glyphicon glyphicon-bookmark"></i> Категории 
                                </a>
                            </li>  

                            <li>
                                <a href="{{url('/admin/tag')}}" class="d-block" data-model="club" onclick="navigation.getPage(event)">
                                    <i class="glyphicon glyphicon-tags"></i> Ключови думи
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/admin/user')}}" class="d-block" data-model="club" onclick="navigation.getPage(event)">
                                    <i class="glyphicon glyphicon-user"></i> Потребиели
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/admin/role')}}" class="d-block" data-model="club" onclick="navigation.getPage(event)">
                                    <i class="glyphicon glyphicon-lock"></i> Права за достъп
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="content col-md-push-2 col-md-10" style="margin-top: 5%">
                @yield('content')
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
