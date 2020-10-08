<?php

namespace App\ViewModel\Sistema\Parametro\Fiscal;

use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscalOrientacaoImpressao;

class UpdateParametroFiscalViewModel
{
    public function inserir(){
        return [
                'id' => '0',
                'numeroproximanotafiscal' => '0',
                'numeroserie' => '0',
                'idnotafiscaltipomovimentacao' => '',
                'NotaFiscalOrientacao' =>  HelperDropDownList::obterBasico(NotaFiscalOrientacaoImpressao::class)
        ];
    }

}