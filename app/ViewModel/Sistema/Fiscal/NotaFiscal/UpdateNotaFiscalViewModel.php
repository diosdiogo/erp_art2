<?php

namespace App\ViewModel\Sistema\Fiscal\NotaFiscal;

use App\Models\Sistema\Endereco\UF;
use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Endereco\EnderecoTipo;

class UpdateNotaFiscalViewModel
{
    public function inserir(){
        return array(
            'id' => 0,
            'descricao' => '',
            'observacao' => 'I - "DOCUMENTO EMITIDO POR ME OU EPP OPTANTE PELO SIMPLES NACIONAL";
II - "NÃO GERA DIREITO A CRÉDITO FISCAL DE ICMS, DE ISS E DE IPI".',
            'codigo' => '',
            'cest' => '',
            'numerodocumentoorigem' => '',
            'dataemissao' => date("Y-m-d"),
            'idpessoa' => '',
            'endereco' => '',
            'numero' => '',
            'complemento' => '',
            'bairro' => '',
            'idcidade' => '',
            'pontoreferencia' => '',
            'iduf' => '',
            'enderecotipo' => '',
            'UFs' => HelperDropDownList::obterBasico(UF::class, "codigo"),
            'enderecotipos' => HelperDropDownList::obterBasico(EnderecoTipo::class),
            'cep' => '',
            'cidadeDescricao' => '',
            'idenderecotipo' => '',
            'chaveacesso' => '',
            'valortotal' => '0.00',
            'valorfrete' => '0.00',
            'valorseguro' => '0.00',
            'valordesconto' => '0.00',
            'valoroutras' => '0.00',
            'xmlenvio' => '',
            'xmlretorno' => '',
            'origemvenda' => false,
            'descricaoPessoa' => '',
            'descricaoNaturezaOperacao' => '',
            'idnotafiscalsituacao' => '6',
            'notafiscalitens' => array(),
        );
    }
}
