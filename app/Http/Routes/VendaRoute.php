<?php

namespace App\Http\Routes;

use Route;

class VendaRoute 
{
    public static function rotas(){
        Route::controller('venda', 'Sistema\Venda\VendaController');
        Route::controller('vendasimples', 'Sistema\Venda\VendaSimplesController');
    } 
}