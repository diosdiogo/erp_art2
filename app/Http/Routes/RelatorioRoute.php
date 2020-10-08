<?php

namespace App\Http\Routes;

use Route;

class RelatorioRoute
{
    public static function rotas(){
        Route::controller('relatoriovenda', 'Sistema\Relatorio\Venda\RelatorioVendaController');
    }
}
