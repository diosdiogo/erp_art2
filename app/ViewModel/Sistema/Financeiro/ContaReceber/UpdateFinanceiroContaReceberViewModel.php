<?php

namespace App\ViewModel\Sistema\Financeiro\ContaReceber;
use App\Models\Sistema\Financeiro\ContaGerencial\FinanceiroContaGerencial;
use App\Enums\FinanceiroMovimentoTipoEnum;

class UpdateFinanceiroContaReceberViewModel 
{
    public function inserir(){
        return array(
            'id' => '0',
            'idfinanceirocontagerencial' => '',
            'financeirocontagerenciais' => FinanceiroContaGerencial::Where('idfinanceiromovimentotipo', FinanceiroMovimentoTipoEnum::ENTRADA)->get(),
            'codigobarras' => '',
            'descricao' => '',
            'observacao' => '',
            'datavencimento' => date("Y-m-d"),
            'valortotal' => '0.00',
            'descricaoSituacao' => 'NOVA',
            'idsituacao' => ''
        );
    }
}