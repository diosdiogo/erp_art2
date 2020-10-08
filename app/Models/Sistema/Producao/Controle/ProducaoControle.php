<?php

namespace App\Models\Sistema\Producao\Controle;

use App\Models\BaseModel;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Produto\Produto;
use App\Models\Sistema\Producao\Maquina\ProducaoMaquina;

class ProducaoControle extends BaseModel
{
    protected $fillable = ['ativo',
                            'idempresa',
                            'dataexecucao',
                            'observacao',
                            'idpessoa',
                            'idproduto',
                            'estoquequantidade',
                            'idproducaomaquina'];


    public function produto(){
        return $this->belongsTo(Produto::class, 'idproduto');
    }

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'idpessoa');
    }

    public function maquina(){
        return $this->belongsTo(ProducaoMaquina::class, 'idproducaomaquina');
    }

    public function validarInserir(){
        return [
            'idproduto' => 'required',
            'idpessoa' => 'required',
            'idproducaomaquina' => 'required',
            'estoquequantidade' => 'required',
            'observacao' => 'required|max:250'
        ];
    }

    public function validarAlias(){
        return [
            'idpessoa' => 'Pessoa',
            'idproduto' => 'Produto',
            'idproducaomaquina' => 'Máquina',
            'estoquequantidade' => 'Quantidade',
            'observacao' => 'Observação',
        ];
    }
}
