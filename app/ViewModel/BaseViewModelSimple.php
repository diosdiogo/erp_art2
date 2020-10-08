<?php

namespace App\ViewModel;

class BaseViewModelSimple
{
    public function inserir(){
        return array(
            'id' => 0,
            'ativo' => true,
            'descricao' => ''
        );
    }
}