<?php

namespace App\ViewModel\Sistema\Financeiro\ContaPagar;
use App\Models\Sistema\Financeiro\ContaGerencial\FinanceiroContaGerencial;
use App\Enums\FinanceiroMovimentoTipoEnum;

class UpdateFinanceiroContaPagarViewModel
{
    public function inserir(){
        return array(
            'id' => '0',
            'idfinanceirocontagerencial' => '',
            'financeirocontagerenciais' => FinanceiroContaGerencial::Where('idfinanceiromovimentotipo', FinanceiroMovimentoTipoEnum::SAIDA)->get(),
            'codigobarras' => '',
            'descricao' => '',
            'observacao' => '',
            'datavencimento' => date("Y-m-d"),
            'valor' => '',
            'descricaoSituacao' => 'NOVA',
            'valortotal' => '0.00',
            'idsituacao' => '',
        );
    }
}