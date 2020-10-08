<?php

namespace App\Http\Routes;

use Route;

class GraficoRoute 
{
    public static function rotas(){
        Route::controller('graficovenda', 'Sistema\Grafico\Venda\GraficoVendaController');
    } 
}
