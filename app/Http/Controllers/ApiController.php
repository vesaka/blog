<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Socialite;

class ApiController extends BaseController {

    public function user() {
        echo "user";
    }

    public function getInfo() {
        echo "URA";
    }

    public function redirect() {
        return Socialite::driver('facebook')->redirect();
    }
    public function callback()
    {
        $user = Socialite::driver('facebook')->user();
        
        
        // $user->token;
    }

}
