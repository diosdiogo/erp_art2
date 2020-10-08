<?php

namespace App\Servico\Dominio;

class ServicoDeFinanceiroConta extends ServicoDeDominioBase
{
    public function __construct()
    {
        parent::__construct("financeiroconta");
    }

    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
            'agencia' => 'required|max:9',
            'agenciadigito' => 'required|max:2',
            'conta' => 'required|max:20',
            'contadigito' => 'required|max:2'
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
            'agencia' => 'Agencia',
            'agenciadigito' => 'Agencia digito',
            'conta' => 'Conta',
            'contadigito' => 'Conta digito'
        ];
    }
}