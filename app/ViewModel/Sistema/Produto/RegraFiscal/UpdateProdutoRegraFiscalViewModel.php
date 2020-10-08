<?php

namespace App\ViewModel\Sistema\Produto\RegraFiscal;

class UpdateProdutoRegraFiscalViewModel
{
    public function inserir(){
        return array(
                'id' => '0',
                'ativo' => 'true',
                'descricao' => '',
            );
    }
}