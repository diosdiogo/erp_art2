<?php

namespace App\ViewModel\Sistema\Producao\Controle;

use App\ViewModel\BaseViewModel;

class UpdateProducaoControleViewModel extends BaseViewModel
{
 
  public function inserir(){
        return array(
            'id' => '0',
            'ativo' => 'true',
            'idpessoa' => '',
            'idproduto' => '',
            'quantidade' => '',
            'dataexecucao' => date("Y-m-d"),
            'observacao' => '',
            'estoquequantidade' => '0',
            'descricaoproduto' => '',
            'descricaopessoa' => '',
            'idproducaomaquina' => '',
            'descricaoproducaomaquina' => ''
        );
    }
}