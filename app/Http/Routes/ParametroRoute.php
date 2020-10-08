<?php

namespace App\Http\Routes;

use Route;

class ParametroRoute 
{
    public static function rotas(){
        Route::controller('parametrofinanceiro', 'Sistema\Parametro\Financeiro\ParametroFinanceiroController');
        Route::controller('parametromercadoria', 'Sistema\Parametro\Mercadoria\ParametroMercadoriaController');
        Route::controller('parametrofiscal', 'Sistema\Parametro\Fiscal\ParametroFiscalController');
        Route::controller('parametrofaturamento', 'Sistema\Parametro\Faturamento\ParametroFaturamentoController');
    } 
}