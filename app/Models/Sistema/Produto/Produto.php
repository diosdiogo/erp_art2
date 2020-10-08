<?php

namespace App\Models\Sistema\Produto;

use App\Models\BaseModel;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Fiscal\NCM\FiscalNCM;
use App\Models\Sistema\Fiscal\CEST\FiscalCEST;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;
use App\Models\Sistema\Fiscal\CST\FiscalCSTICMS;
use App\Models\Sistema\UnidadeMedida\UnidadeMedida;

class Produto extends BaseModel
{
    protected $fillable = ['ativo',
                        'idempresa',
                        'idprodutomarca',
                        'idunidademedida',
                        'idprodutocategoria',
                        'idprodutocategoria',
                        'descricao',
                        'codigobarra',
                        'descricaoadicional',
                        'idprodutofiscaltipo',
                        'ativo',
                        'custocompra',
                        'preco',
                        'modelo',
                        'quantidade',
                        'estoquequantidade',
                        'habilitacontroleestoque',
                        'codigofornecedor',
                        'descricaofornecedor',
                        'estoqueunidade',
                        'codigoreduzido',
                        'codigobarra',
                        'estoquequantidadecaixa',
                        'idorigemmercadoria',
                        'peso',
                        'largura',
                        'altura',
                        'comprimento',
                        'idfiscalcest',
                        'idfiscalncm',
                        'observacao',
                        'codigobalanca',
                        'habilitabalanca',
                        'idpessoafornecedor',
                        'idcstpis',
                        'idcstcofins',
                        'idcstipi',
                        'idcfop',
                        'idcsticms',
                        'ipi',
                        'icms',
                        'pis',
                        'cofins',
                        'contabilizaestoque'];

   public function fiscalNCM(){
       return $this->belongsTo(FiscalNCM::class, 'idfiscalncm');
   }

   public function fiscalCEST(){
       return $this->belongsTo(FiscalCEST::class, 'idfiscalcest');
   }

   public function cfop(){
       return $this->belongsTo(FiscalCFOP::class, 'idcfop');
   }

   public function cstICMS(){
       return $this->belongsTo(FiscalCSTICMS::class, 'idcsticms');
   }

   public function pessoaFornecedor(){
       return $this->belongsTo(Pessoa::class, 'idpessoafornecedor');
   }

   public function unidadeMedida(){
       return $this->belongsTo(UnidadeMedida::class, 'idunidademedida');
   }

    public function validarInserir(){
        return [
            'descricao' => 'required|unique:produto|max:100',
            'codigobarra' => 'max:100|unique:produto',
            'descricaoadicional' => 'max:15',
            'codigoreduzido' => 'max:20',
            'preco' =>  'required',
            'idunidademedida' => 'required|integer',
            'modelo' => 'max:100',
            'codigobalanca' => 'max:5',
            'codigofornecedor' => 'max:20',
            'descricaofornecedor' => 'max:100',
           /* 'idorigemmercadoria' => 'required',
            'idprodutofiscaltipo' => 'required'*/
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
            'idunidademedida' => 'Unidade',
            'idorigemmercadoria' => 'Grupo Fiscal - Origem da mercadoria',
            'idprodutofiscaltipo' => 'Grupo Fiscal - Tipo'
        ];
    }

    public function baixarEstoque($quantidade, $quantidadepeca){
        $this->attributes['estoquequantidade'] -= $quantidade;
        if($quantidadepeca > 0)
            $this->attributes['estoqueunidade'] -= $quantidadepeca;
    }

    public function devolverEstoque($quantidade, $quantidadepeca){
        $this->attributes['estoquequantidade'] += $quantidade;
        if($quantidadepeca > 0)
            $this->attributes['estoqueunidade'] += $quantidadepeca;
    }
}