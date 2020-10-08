<?php

namespace App\ViewModel\Sistema\Venda;

use App\ViewModel\BaseViewModel;

class VendaSimplesItemViewModel extends BaseViewModel {

    const CAMPOS = array('id' => '', 'ordem' => '', 'idproduto' => '', 
    'idvenda' => '', 'acrescimomoeda' => 0, 'descontomoeda' => 0, 'valorunitario' => 0, 'valortotal' => 0, 'descricao' => '', 'quantidade' => 1, 'descontoporcentagem' => '0'
    , 'quantidadequadrado' => '1', 'quantidadepeca' => '0', 'quantidadequadradotexto' => "", 'altura' => '0', 'largura' => '0', 'produtonomegenerico' => '');

    public function rules()
    {
        return [
            'idproduto' => 'required',
            'valorunitario' => 'required',
        ];
    }
} 