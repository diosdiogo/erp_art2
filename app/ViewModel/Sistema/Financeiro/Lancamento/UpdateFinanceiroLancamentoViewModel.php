<?php

namespace App\ViewModel\Sistema\Financeiro\Lancamento;

use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamentoTipoLancamento;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamentoTipo;
use App\Models\Sistema\Financeiro\ContaGerencial\FinanceiroContaGerencial;
use App\Models\Sistema\Financeiro\Conta\FinanceiroConta;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;

class UpdateFinanceiroLancamentoViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'idempresa' => '1',
            'observacao' => '',
            'datalancamento' => date("Y-m-d"),
            'valor' => '',
            'idlancamentotipolancamento' => '1',
            'lancamentotipolancamentos' => FinanceiroLancamentoTipoLancamento::get(),
            'idfinanceirolancamentotipo' => '',
            'financeirolancamentotipos' => FinanceiroLancamentoTipo::get(),
            'idfinanceirocontagerencial' => '',
            'financeirocontagerenciais' => FinanceiroContaGerencial::get(),
            'numerodocumento' => '',
            'idfinanceirocontaorigem' => '',
            'idfinanceirocontadestino' => '',
            'financeirocontas' => FinanceiroConta::get(),
            'idfinanceiroformarecebimento' => '',
            'financeiroformarecebimentos' => FinanceiroFormaRecebimento::get(),
            'descontomoeda' => '',
            'jurosmoeda' => '',
            'descricaofinanceirocontareceber' => '',
            'idfinanceirocontareceber' => '',
            'contaReceberOuPagarDescricao' => '',
            'idfinanceirocontapagar' => '',            
            'descricaoDocumento' => '',
            'datavencimento' => 'DD-MM-YYYY',
            'valortotalreceber' => '0,00',
        );
    }
}