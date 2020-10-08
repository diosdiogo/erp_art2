<?php

namespace App\Models\Sistema\Transportadora;
use App\Models\BaseModel;

class Transportadora extends BaseModel
{
    protected $fillable = array('idempresa', 'descricao', 'placa', 'ativo');

    public function validarInserir(){
        return [
            'descricao' => 'required|unique:transportadora|max:100',
            'placa' => 'required|max:12|',
        ];
    }
}