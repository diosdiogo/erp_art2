<?php

namespace App\Models\Sistema\Venda;
use App\Models\BaseModel;
use App\Models\Sistema\Produto\Produto;

class VendaItem extends BaseModel
{
    protected $fillable = ['ordem', 'idproduto', 'idvenda', 'acrescimomoeda', 'descontomoeda',
    'valorunitario', 'valortotal', 'quantidade', 'descontoporcentagem', 'quantidadequadrado', 'quantidadepeca', 'quantidadequadradotexto',
    'altura', 'largura', 'produtonomegenerico'];


    public function produto(){
        return $this->belongsTo(Produto::class, 'idproduto');
    }

    public function validarInserir(){
        return [
         
        ];
    }

    public function validarAlias(){
        return [
            
        ];
    }
}
