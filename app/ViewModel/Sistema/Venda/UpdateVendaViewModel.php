<?php

namespace App\ViewModel\Sistema\Venda;

use App\Models\Sistema\Pessoa\Pessoa;
use App\Enums\PessoaRelacaoEnum;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;
use App\Models\Sistema\Transportadora\Transportadora;

class UpdateVendaViewModel
{
    public function inserir(){
        return array(
            'id' => '0',
            'clientes' => Pessoa::get(),
            'observacao' => '[VENDA COMUM]',
            'orcamento' => 0,
            'datavenda' => date("Y-m-d"),
            'dataentrega' => date("Y-m-d"),
            'idtransportadora' => '1',
            'transportadoras' => Transportadora::get(),
            'idpessoa' => '1',
            'idpessoavendedor' => '',
            'idformarecebimentoitem' => '',  
            'idformarecebimento' => '',
            'financeiroformarecebimentos' => FinanceiroFormaRecebimento::get(),
            'acrescimomoeda' => 0.0,
            'descontomoeda' => 0.0,
            'descontoporcentagem' => 0.0,
            'valortotal' => 0.0,
            'valortroco' => 0.0,
            'vendaitens' => array(),
            'valortotalparcela' => 0.0,
            'diferencia' => 0.0
        );
    }
}