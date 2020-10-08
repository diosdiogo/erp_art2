<?php

namespace App\Http\Controllers\Sistema\Empresa;

use Session;
use Illuminate\Http\Request;
use App\Helper\Sessao\HelperDeSessao;
use App\Models\Sistema\Empresa\Empresa;
use App\Models\Sistema\Endereco\Cidade;
use App\Enums\Sessao\SessaoControllerEnum;
use App\Helper\Controller\HelperDropDownList;
use App\Models\Sistema\Fiscal\CNAE\FiscalCNAE;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;

class EmpresaController extends GridUpdateBaseController
{
    protected $pasta = "empresa";
    protected $inserir = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function eventoDepoisAlterar($model){
        $chaveEmpresa = HelperDeSessao::chaveUnica(SessaoControllerEnum::Empresa);
        Session::put($chaveEmpresa, Empresa::where('id', $model->id)->get());
    }

    public function getObtercidade(Request $request){
        return HelperDropDownList::obter(Cidade::class, $request);
    }

    public function getObtercnae(Request $request){
        return HelperDropDownList::obterDinamico(FiscalCNAE::class, $request, 'codigo');
    }

    public function getObterdescricaocidade(Request $request){
        $cidades = HelperDropDownList::obterDinamico(Cidade::class, $request, "codigo");
        return $cidades->count() ? $cidades[0] : $cidades;
    }

    public function getObtercfop(Request $request){
        return $this->obterDropDownListDinamico(FiscalCFOP::class, $request, "id");
    }
}