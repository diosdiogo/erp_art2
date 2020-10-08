<?php

namespace App\ViewModel\Sistema\Fiscal\CEST;

class UpdateFiscalCESTViewModel
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