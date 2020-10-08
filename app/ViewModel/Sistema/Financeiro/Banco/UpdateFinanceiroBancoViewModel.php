<?php

namespace App\ViewModel\Sistema\Financeiro\Banco;

class UpdateFinanceiroBancoViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'codigobanco' => '0',
            'descricao' => '',
        );
    }
}