<?php

namespace App\Models;

class BaseModelSimple extends BaseModel
{
    protected $fillable = array('idempresa', 'descricao', 'ativo');

    public function validarInserir(){
        return [
            'descricao' => 'required|max:150',
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }
}