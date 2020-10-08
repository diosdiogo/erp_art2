<?php

namespace App\Models\Sistema\Pessoa\RamoAtividade;

use App\Models\BaseModelSimple;

class PessoaRamoAtividade extends BaseModelSimple
{
    protected $fillable = ['ativo', 'idempresa', 'descricao'];

    public function validarInserir(){
         return [
            'descricao' => 'required|unique:pessoaramoatividade|max:100',
        ];
    }

    public function validarAlterar($id){
        return [
            'descricao' => 'required|max:100|unique:pessoaramoatividade,descricao,' .$id,
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descrição',
        ];
    }
}
