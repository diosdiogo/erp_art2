<?php

namespace App\Models\Sistema\Financeiro\FormaRecebimento\Tipo;

use App\Models\BaseModel;

class FinanceiroFormaRecebimentoTipo extends BaseModel
{
    protected $fillable = array('idempresa', 'descricao');

    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }

    public function validarAntesDeAlterar(){
        return [
            'internomobi' => 'not_in:1'
        ];
    }

    public function validarAntesDeDeletar(){
        return [
            'internomobi' => "not_in:1" 
        ];
    }

    public $mensagemAlias = [
        'internomobi.not_in' => 'Não é possivel alterar ou deletar cadastros padrões'
    ]; 
}