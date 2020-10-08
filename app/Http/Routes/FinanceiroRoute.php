<?php

namespace App\Http\Routes;

use Route;

class FinanceiroRoute 
{
    public static function rotas(){
        Route::controller('financeiroconta', 'Sistema\Financeiro\Conta\FinanceiroContaController');
        Route::controller('financeiroformarecebimento', 'Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoController');
        Route::controller('financeirobanco', 'Sistema\Financeiro\Banco\FinanceiroBancoController');
        Route::controller('financeirocontagerencialdemonstrativo', 'Sistema\Financeiro\ContaGerencial\Demonstrativo\FinanceiroContaGerencialDemonstrativoController');
        Route::controller('financeirocontagerencial', 'Sistema\Financeiro\ContaGerencial\FinanceiroContaGerencialController');
        Route::controller('financeirolancamento', 'Sistema\Financeiro\Lancamento\FinanceiroLancamentoController');
        Route::controller('financeirocontapagar', 'Sistema\Financeiro\ContaPagar\FinanceiroContaPagarController');
        Route::controller('financeirocontareceber', 'Sistema\Financeiro\ContaReceber\FinanceiroContaReceberController');
        Route::controller('financeiroformarecebimentotipo', 'Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipoController');
    } 
}
