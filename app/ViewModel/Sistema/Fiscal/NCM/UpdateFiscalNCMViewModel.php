<?php

namespace App\ViewModel\Sistema\Fiscal\NCM;

class UpdateFiscalNCMViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'descricao' => '',
            'codigo' => '',
            'cest' => ''
        );
    }
}