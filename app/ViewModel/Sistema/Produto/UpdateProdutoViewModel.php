<?php

namespace App\ViewModel\Sistema\Produto;

use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;
use App\Models\Sistema\Fiscal\CEST\FiscalCEST;
use App\Models\Sistema\Fiscal\CST\FiscalCSTIPI;
use App\Models\Sistema\Fiscal\CST\FiscalCSTICMS;
use App\Models\Sistema\Produto\Marca\ProdutoMarca;
use App\Models\Sistema\UnidadeMedida\UnidadeMedida;
use App\Models\Sistema\Fiscal\CST\FiscalCSTPISECofins;
use App\Models\Sistema\Produto\Fiscal\ProdutoFiscalTipo;
use App\Models\Sistema\Produto\Categoria\ProdutoCategoria;
use App\Models\Sistema\Parametro\Mercadoria\ParametroMercadoria;
use App\Models\Sistema\Produto\Fiscal\ProdutoFiscalOrigemMercadoria;
class UpdateProdutoViewModel
{
    public function inserir(){
        return array(
                'id' => '0',
                'ativo' => 'true',
                'idprodutomarca' => '0',
                'idprodutocategoria' => '0',
                'descricao' => '',
                'codigobarra' => '',
                'descricaoadicional' => '',
                'habilitabalanca' => '0',
                'codigobalanca' => '',
                'unidadesmedida' => HelperDropDownList::obterBasico(UnidadeMedida::class),
                'categorias' => HelperDropDownList::obterBasico(ProdutoCategoria::class),
                'marcas' => HelperDropDownList::obterBasico(ProdutoMarca::class),
                'fiscalorigensmercadoria' => HelperDropDownList::obterBasico(ProdutoFiscalOrigemMercadoria::class),
                'codigocest' => '0',
                'fiscalTipos' => HelperDropDownList::obterBasico(ProdutoFiscalTipo::class),
                'habilitapdv' => 'false',
                'habilitacontroleestoque' => 'false',
                'habilitanf' => 'false',
                'custocompra' => '0',
                'preco' => '0',
                'idunidademedida' => '0',
                'idprodutofiscaltipo' => '0',
                'idfiscalncm' => '0',
                'idprodutofiscalorigemmercadoria' => '0',
                'idorigemmercadoria' => '0',
                'idprodutocategoria' => '0',
                'modelo' => '',
                'estoquequantidade' => '0',
                'estoqueunidade' => '1',
                'codigofornecedor' => '',
                'descricaofornecedor' => '',
                'codigoreduzido' => '',
                'estoquequantidadecaixa' => '',
                'peso' => '',
                'largura' => '',
                'altura' => '',
                'idfiscalcest' => '',
                'comprimento' => '',
                'observacao' => '',
                'cestdescricaobanco' => '',
                'ncmdescricaobanco' => '',
                'descricaopessoafornecedor' => '',
                'idpessoafornecedor' => '',
                'usadetalhe' => ParametroMercadoria::first()->usadetalhe,
                'fiscalcestpiscofins' => HelperDropDownList::obterBasicoViewModel(FiscalCSTPISECofins::class, "codigo"),
                'fiscalcestipi' => HelperDropDownList::obterBasicoViewModel(FiscalCSTIPI::class, "codigo"),
                'fiscalcfop' => HelperDropDownList::obterBasicoViewModel(FiscalCFOP::class),
                'fiscalcsticms' => HelperDropDownList::obterBasicoViewModel(FiscalCSTICMS::class, "codigo"),
                'idcstpis' => '',
                'idcstcofins' => '',
                'idcstipi' => '',
                'idcfop' => '',
                'idcstcms' => '',
                'ipi' => '',
                'icms' => '',
                'pis' => '',
                'cofins' => '',
                'idcsticms' => '',
                'contabilizaestoque' => 'true',
                'desabilitarSimplesNacional' => false
            );
    }
}