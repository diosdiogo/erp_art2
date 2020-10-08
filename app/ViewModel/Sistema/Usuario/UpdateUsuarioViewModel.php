<?php

namespace App\ViewModel\Sistema\Usuario;

//use App\Models\Sistema\Pessoa\Pessoa;

class UpdateUsuarioViewModel
{
    public function inserir(){
        return array(
            'id' => '0',
            'ativo' => '1',
            'email' => '',
            'name' => '',
            'password' => '',
            'supervisor' => '0'
        );
    }
}