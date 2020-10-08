<?php

namespace App\ViewModel\Sistema\Financeiro\Conta;

use App\Models\Sistema\Financeiro\Banco\FinanceiroBanco;

class UpdateFinanceiroContaViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'idempresa' => '1',
            'ativo' => true,
            'descricao' => '',
            'agencia' => '',
            'agenciadigito' => '',
            'conta'=> '',
            'contadigito' => '',
            'principal' => false,
            'idfinanceirobanco' => '0',
            'descricaobanco' => ''
        );
    }
}