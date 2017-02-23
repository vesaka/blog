<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */
Route::get('/image/getby/{category_id}', 'ImageController@getImagesBy');
Route::get('/image/getall', 'ImageController@getAll');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
        ], function() {

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index');
    Route::get('/portfolio', 'HomeController@portfolio');
    Route::get('/games', 'HomeController@games');
    Route::get('/blog', 'HomeController@blog');
    Route::get('/about', 'HomeController@about');
    Route::get('/contact', 'HomeController@contact');
    Route::get('/image/{id}/{name}', 'ImageController@getImageAndFeaturedEntites');
    Route::get('/article/{id}/{name}', 'ArticleController@getArticleAndFeaturedEntites');
    Route::get('/search', 'HomeController@search');
    Route::get('/search/articles/{category_id}', 'SearchController@findArticlesByCategory');
    Route::auth();
    
});

Route::group(['prefix' => '/admin', 'middleware' => 'auth'], function() {
    Route::get('/', function() {
        return view('admin.dashboard');
    });
    Route::resource('/image', 'ImageController');
    Route::resource('/article', 'ArticleController');
    Route::resource('/category', 'CategoryController');
    Route::resource('/tag', 'TagController');
    Route::resource('/quote', 'QuoteController');
    Route::resource('/user', 'UserController');
    Route::resource('/role', 'RoleController');
});

Route::post('/login', 'Auth\LoginController@login');
Route::post('/register', 'Auth\RegisterController@register');

Route::get('/user', 'ApiController@user');
Route::get('/redirect', 'ApiController@redirect');
Route::get('/callback', 'ApiController@callback');

Route::get('/auth/facebook', 'ApiController@redirect');
Route::get('/auth/facebook/callback', 'ApiController@callback');

Route::get('/facebook/login', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    // Send an array of permissions to request
    $login_url = $fb->getLoginUrl(['email']);
    var_dump($login_url);

    // Obviously you'd do this in blade :)
    echo '<a href="' . $login_url . '">Login with Facebook</a>';
});

Route::get('/facebook/callback', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    try {
        $token = $fb->getAccessTokenFromRedirect();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    if (!$token) {
        $helper = $fb->getRedirectLoginHelper();

        if (!$helper->getError()) {
            abort(403, 'Unauthorized action.');
        }

        dd(
                $helper->getError(), $helper->getErrorCode(), $helper->getErrorReason(), $helper->getErrorDescription()
        );
    }

    if (!$token->isLongLived()) {
        // OAuth 2.0 client handler
        $oauth_client = $fb->getOAuth2Client();

        // Extend the access token.
        try {
            $token = $oauth_client->getLongLivedAccessToken($token);
        } catch (Facebook\Exceptions\FacebookSDKException $e) {
            dd($e->getMessage());
        }
    }

    $fb->setDefaultAccessToken($token);
    Session::put('fb_user_access_token', (string) $token);

    try {
        $response = $fb->get('/me?fields=id,name,email');
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        dd($e->getMessage());
    }

    // Convert the response to a `Facebook/GraphNodes/GraphUser` collection
    $facebook_user = $response->getGraphUser();

    $user = App\User::createOrUpdateGraphNode($facebook_user);
    Auth::login($user);

    return redirect('/user')->with('message', 'Successfully logged in with Facebook');
});

Route::match(['get', 'post'], '/facebook/canvas', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    try {
        $token = $fb->getCanvasHelper()->getAccessToken();
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        // Failed to obtain access token
        dd($e->getMessage());
    }

    // $token will be null if the user hasn't authenticated your app yet
    if (!$token) {
        var_dump("No valid token found");
    }

});

Route::get(env('FACEBOOK_PAGE') . '/posts', function(SammyK\LaravelFacebookSdk\LaravelFacebookSdk $fb) {
    $token = Session::get('fb_user_access_token');
    //var_dump($token);
    $fb->setDefaultAccessToken($token);
    $fb->post($endpoint, $params, $token, $eTag);
});
