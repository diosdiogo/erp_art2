<?php

namespace App\Http\Routes;

use Illuminate\Support\Facades\Auth;
use Route;

class AutenticacaoRoute 
{
    public static function rotas(){
        Route::get('/', function () {
            if(Auth::guest())
                return redirect()->intended('home');
            else
                return redirect('home');
        });
    } 
}
