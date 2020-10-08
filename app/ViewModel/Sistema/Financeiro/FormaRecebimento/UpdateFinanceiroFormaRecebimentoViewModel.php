<?php

namespace App\ViewModel\Sistema\Financeiro\FormaRecebimento;

use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipo;

class UpdateFinanceiroFormaRecebimentoViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'idempresa' => '1',
            'ativo' => true,
            'descricao' => '',
            'numeroparcelas' => '',
            'recorrencia' => '',
            'diaprimeiraparcela' => '',
            'utilizacompra' => '',
            'utilizavenda' => '',
            'formarecebimentoitens' => array(),
            'idfinanceirotipo' => 0,
            'tipos' => HelperDropDownList::obterBasico(FinanceiroFormaRecebimentoTipo::class),
        );
    }
}