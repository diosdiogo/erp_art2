<?php

namespace App\ViewModel\Sistema\Transportadora;

class UpdateTransportadoraViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'ativo' => true,
            'descricao' => '',
            'placa' => '',
        );
    }
}