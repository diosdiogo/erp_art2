<?php

namespace App\ViewModel\Sistema\Empresa;

use Illuminate\Http\Request;
use App\Models\Sistema\Empresa\Ambiente;
use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Fiscal\FiscalRegimeTributario;

class UpdateEmpresaViewModel
{
    public function inserir(){
        return[
            'razaosocial' => '',
            'nomefantasia' => '',
            'email' => '',
            'cnpj' => '',
            'emp' => '1',
            'matriz' => '1',
            'inscricaomunicipal' => '',
            'inscricaoestadual' => '',
            'cep' => '',
            'bairro' => '',
            'endereco' => '',
            'numero' => '',
            'complemento' => '',
            'cidade' => '',
            'pontoreferencia' => '',
            'idfiscalregimetributario' => '',
            'descricaorelatorio' => 'teste',
            'regimes' => HelperDropDownList::obterBasico(FiscalRegimeTributario::class),
            'ambientes' => HelperDropDownList::obterBasico(Ambiente::class),
            'idambiente' => '2',
            'idcidade' => '',
            'cidadeDescricao' => '',
            'idcnae' => '',
            'cnaeDescricao' => '',
            'senha' => '',
            'fraserelatorio' => '',
            'idfiscalcfopdentroestado' => 0,
            'idfiscalcfopforaestado' => 0,
            'CFOPDentrodescricaobanco' => '',
            'CFOPForadescricaobanco' => ''
        ];
    }
}
