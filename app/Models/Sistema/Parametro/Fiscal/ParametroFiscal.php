<?php

namespace App\Models\Sistema\Parametro\Fiscal;

use App\Models\BaseModel;

class ParametroFiscal extends BaseModel
{
    protected $fillable = ['idempresa', 'descricao', 'numeroproximanotafiscal', 'numeroserie', 'idnotafiscalorientacaoimpressao'];

    public function validarInserir(){

        return [
            'numeroserie' => 'numeric|min:0|max:889',
        ];
    }

    public function validarAlterar($id = ''){
        return [
            'numeroserie' => 'numeric|min:0|max:889',
        ];
    }

    public function validarAlias(){
        return [
            'numeroserie' => 'Número de serie',
        ];
    }
}