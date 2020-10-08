<?php

namespace App\Models\Sistema\Fiscal\NotaFiscal;

use App\Models\BaseModel;
use App\Models\Sistema\Produto\Produto;
use App\Models\Sistema\Fiscal\NCM\FiscalNCM;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;
use App\Models\Sistema\UnidadeMedida\UnidadeMedida;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscal;
use App\Models\Sistema\Fiscal\CST\FiscalCSTICMS;

class NotaFiscalItem extends BaseModel
{
        protected $fillable =  ['idproduto',
                                'idnotafiscal',
                                'item',
                                'codigo',
                                'descricao',
                                'idunidademedida',
                                'idcfop',
                                'quantidade',
                                'valorunitario',
                                'valortotal',
                                'valorfrete',
                                'valorseguro',
                                'valordesconto',
                                'valortotalitem',
                                'valoroutro',
                                'valorunitariotributavel',
                                'quantidadetributavel',
                                'codigogtincomercial',
                                'codigogtintributavel',
                                'unidademedidacomercial',
                                'unidademedidatributavel',
                                'idncm',
                                'fci',
                                'idcest',
                                'produtonomegenerico',
                                'compoetotalnotafiscal',
                                'idcsticms'];

    public function produto(){
        return $this->belongsTo(Produto::class, 'idproduto');
    }

    public function notaFiscal(){
        return $this->belongsTo(NotaFiscal::class, 'idnotafiscal');
    }

    public function cstICMS(){
        return $this->belongsTo(FiscalCSTICMS::class, 'idcsticms');
    }

    public function unidadeMedida(){
        return $this->belongsTo(UnidadeMedida::class, 'idunidademedida');
    }

    public function ncm(){
        return $this->belongsTo(FiscalNCM::class, 'idncm');
    }

    public function cfop(){
        return $this->belongsTo(FiscalCFOP::class, 'idcfop');
    }

    public function cst(){
        return $this->belongsTo(FiscalCFOP::class, 'idcst');
    }

    public function validarInserir(){
        return [

        ];
    }

    public function validarAlterar(){
        return [

        ];
    }

    public function validarAlias(){
        return [

        ];
    }
}
