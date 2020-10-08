<?php

namespace App\ViewModel\Sistema\Fiscal\NaturezaOperacao;

use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Financeiro\FinanceiroMovimentoTipo;
use App\Models\Sistema\Fiscal\NaturezaOperacao\NaturezaOperacaoFinalidade;

class UpdateFiscalNaturezaOperacaoViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'ativo' => true,
            'descricao' => '',
            'emissaopropria' => '',
            'idfiscalCFOPDentroEstado' => '',
            'idfiscalCFOPForaEstado' => '',
            'idfinanceiromovimentotipo' => '',
            'financeiromovimentostipo' => FinanceiroMovimentoTipo::get(),
            'CFOPForadescricaobanco' => '',
            'CFOPDentrodescricaobanco' => '',
            'idnaturezaoperacaofinalidade' => '',
            'naturezaoperacaofinalidade' => HelperDropDownList::obterBasico(NaturezaOperacaoFinalidade::class),
        );
    }
}