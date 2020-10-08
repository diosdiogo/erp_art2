<?php

namespace App\Servico\Dominio;

class ServicoDeDominioBase
{
    protected $pasta;

    public function __construct($pasta)
    {
        $this->pasta = $pasta;
    }

    public function validarInserir(){
        return [
            'descricao' => 'required|max:100' . $this->validarDescricao()
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }

    private function validarDescricao(){
        return $this->tabela == '' ? '' : ('|unique:' . $this->tabela);
    }
}