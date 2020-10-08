<?php

namespace App\ViewModel\Sistema\Financeiro\ContaGerencial;

use App\Models\Sistema\Financeiro\ContaGerencial\Demonstrativo\FinanceiroContaGerencialDemonstrativo;
use App\Models\Sistema\Financeiro\FinanceiroMovimentoTipo;
class UpdateFinanceiroContaGerencialViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'idempresa' => '1',
            'ativo' => true,
            'descricao' => '',
            'idfinanceirodemonstrativo' => '',
            'idfinanceiromovimentotipo' => '',
            'debito'=> '',
            'credito' => '',
            'compras' => false,
            'demonstrativos' => FinanceiroContaGerencialDemonstrativo::get(),
            'movimentotipos' => FinanceiroMovimentoTipo::get(),
        );
    }
}