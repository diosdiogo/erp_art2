<?php

namespace App\Models\Sistema\Produto\RegraFiscal;

use App\Models\BaseModel;

class ProdutoRegraFiscal extends BaseModel
{
     protected $fillable = ['ativo',
                        'idempresa',
                        'descricao'];


    public function validarInserir(){
        return [
            'descricao' => 'required|unique:produto|max:150',
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }
}
