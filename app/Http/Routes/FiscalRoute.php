<?php

namespace App\Http\Routes;

use Route;

class FiscalRoute 
{
    public static function rotas(){
        Route::controller('fiscalncm', 'Sistema\Fiscal\NCM\FiscalNCMController');
        Route::controller('fiscalcest', 'Sistema\Fiscal\CEST\FiscalCESTController');
        Route::controller('fiscalcfop', 'Sistema\Fiscal\CFOP\FiscalCFOPController');
        Route::controller('fiscalnaturezaoperacao', 'Sistema\Fiscal\NaturezaOperacao\FiscalNaturezaOperacaoController');
        Route::controller('notafiscal', 'Sistema\Fiscal\NotaFiscal\NotaFiscalController');
    } 
}

