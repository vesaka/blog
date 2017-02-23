<?php

return [

    /*
      |--------------------------------------------------------------------------
      | View Storage Paths
      |--------------------------------------------------------------------------
      |
      | Most templating systems load templates from disk. Here you may specify
      | an array of paths that should be checked for your views. Of course
      | the usual Laravel view path has already been registered for you.
      |
     */

    'paths' => [
        realpath(base_path('resources/views')),
    ],
    /*
      |--------------------------------------------------------------------------
      | Compiled View Path
      |--------------------------------------------------------------------------
      |
      | This option determines where all the compiled Blade templates will be
      | stored for your application. Typically, this is within the storage
      | directory. However, as usual, you are free to change this value.
      |
     */
    'compiled' => realpath(storage_path('framework/views')),
    'bootstrap' => [
        'version' => '3.3.7',
        'self' => [
            'min_css' => 'bootstrap/bootstrap-%s.min.css',
            'css' => 'bootstrap/bootstrap-%s.css',
            'js' => '',
        ],
        'cdn' => [
            'min_css' => 'https://maxcdn.bootstrapcdn.com/bootswatch/%s/%s/bootstrap.min.css',
            'css' => 'https://maxcdn.bootstrapcdn.com/bootswatch/%s/%s/bootstrap.css',
            'js' => '//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.js',
            'min_js' => '//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js',
        ],
        'theme' => 'cosmo',
        'themes' => [
            'cerulean',
            'cosmo',
            'cyborg',
            'darkly',
            'flatly',
            'journal',
            'lumen',
            'paper',
            'readable',
            'sandstone',
            'simplex',
            'slate',
            'spacelab',
            'superhero',
            'united',
            'yeti',
        ],
    ],
    'css' => [
        '/bootstrap/dist/css/bootstrap.min.css',
        '/assets/css/main.css',
    ],
    'js' => [
        '/assets/js/jquery/jquery.min.js',
        '/bootstrap/dist/js/bootstrap.min.js',
        '/assets/js/jquery/cropper/dist/cropper.min.js',
    ],
    'admin-css' => [
        '/adminlte/bootstrap/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        '/adminlte/dist/css/AdminLTE.min.css',
        '/adminlte/dist/css/skins/_all-skins.min.css',
        '/adminlte/plugins/iCheck/flat/red.css',
        '/assets/css/main.css',
        '/assets/css/cropper.min.css',
//        '/adminlte/plugins/morris/morris.css',
//        '/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.css',
//        '/adminlte/plugins/datepicker/datepicker3.css',
//        '/adminlte/plugins/daterangepicker/daterangepicker-bs3.css',
//        '/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
    ],
    'admin-js' => [
        '/assets/js/jquery/jquery.min.js',
        '/bootstrap/dist/js/bootstrap.min.js',
        '/app/admin.js',
        '/app/controllers/dashboard.js',
        '/adminlte/dist/js/app.js',
        '/assets/js/cropper.min.js',
        '/assets/js/main.js',
//        'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js',
//        '/adminlte/plugins/morris/morris.min.js',
//        '/adminlte/plugins/sparkline/jquery.sparkline.min.js',
//        '/adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
//        '/adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
//        '/adminlte/plugins/knob/jquery.knob.js',
//        'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js',
//        '/adminlte/plugins/daterangepicker/daterangepicker.js',
//        '/adminlte/plugins/datepicker/bootstrap-datepicker.js',
//        '/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
//        '/adminlte/plugins/slimScroll/jquery.slimscroll.min.js',
//        '/adminlte/plugins/fastclick/fastclick.js',
//        '/adminlte/dist/js/pages/dashboard.js',
//        '/adminlte/dist/js/demo.js',
    ],
    'menu' => [
        'home' => [
            'class' => 'active'
        ],
        'article' => [
            'sublinks' => [
                'index' => [
                    'href' => 'article',
                    'title' => 'List',
                    'icon-class' => 'fa fa-paper',
                ],
                'add' => [
                    'href' => 'article/add',
                    'title' => 'Create article',
                    'icon-class' => 'fa fa-plus-circle',
                ]
            ],
            'title' => 'Artcles',
            'icon-class' => 'fa fa-plus-circle',
        ],
        'image' => [
            'sublinks' => [
                'index' => [
                    'href' => 'image',
                    'title' => 'List',
                    'icon-class' => 'fa fa-paper',
                ],
                'add' => [
                    'href' => 'image/add',
                    'title' => 'Upload image(s)',
                    'icon-class' => 'fa fa-plus-circle',
                ],
            ],
            'title' => 'Images',
            'icon-class' => 'fa fa-plus-circle',
        ],
        'events' => [],
        'about' => [
            'href' => '',
            'title' => '',
            'icon-class' => '',
        ],
    ],
];
