<?php

namespace App\ViewModel\Sistema\Parametro\Faturamento;

class UpdateParametroFaturamentoViewModel
{
    public function inserir(){
        return [
                'id' => '0',
                'recalcularformarecebimento' => '0',
                'idempresa' => '',
        ];
    }

}