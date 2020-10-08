<?php

namespace App\ViewModel\Sistema\Fiscal\NotaFiscal;

use App\ViewModel\BaseViewModel;
use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\UnidadeMedida\UnidadeMedida;

class UpdateNotaFiscalItemViewModel
{
    public static function campos(){
        return [
            'id' => '', 'ordem' => '', 'idproduto' => '',
            'idvenda' => '', 'acrescimomoeda' => 0, 'descontomoeda' => 0, 'valorunitario' => 0, 'valortotal' => 0, 'descricao' => '', 'quantidade' => 1, 'descontoporcentagem' => '0'
            , 'quantidadequadrado' => '0', 'idunidademedida' => '0', 'quantidadequadradotexto' => "", 'altura' => '0', 'largura' => '0',
            'unidadesmedida' => HelperDropDownList::obterBasico(UnidadeMedida::class), 'descricaocsticms' => '', 'descricaocfop' => '', 'idcsticms' => '', 'produtonomegenerico' => '', 'unidademedidacomercial' => 'un', 'valordesconto' => '0'
        ];
    }
    public function rules()
    {
        return [

        ];
    }
}
