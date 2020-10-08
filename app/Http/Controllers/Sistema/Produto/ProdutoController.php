<?php

namespace App\Http\Controllers\Sistema\Produto;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Enums\FiscalRegimeTributarioEnum;
use App\Constants\Produto\ProdutoConstans;
use App\Models\Sistema\Fiscal\NCM\FiscalNCM;
use App\Models\Sistema\Fiscal\CEST\FiscalCEST;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

class ProdutoController extends GridUpdateBaseController
{
    protected $pasta = "produto";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObtercest(Request $request){
        $bancos = $this->obterDropDownListDinamico(FiscalCEST::class, $request, 'codigo');
        return $bancos;
    }

    public function getObterncm(Request $request){
        $bancos = $this->obterDropDownListDinamico(FiscalNCM::class, $request, 'codigo');
        return $bancos;
    }

    public function getObterpessoafornecedor(Request $request){
        $bancos = $this->obterBasicoWhere(Pessoa::class, $request, ' (SELECT idpessoarelacao FROM pessoaepessoarelacao WHERE idpessoa = pessoa.id) > 1', 'razaosocial');
        return $bancos;
    }
    
    protected function preencherViewModel(&$viewModel){
        if($this->sessionProperties->obterEmpresaBasico()['idfiscalregimetributario'] == FiscalRegimeTributarioEnum::SIMPLESNACIONAL){
            $viewModel['desabilitarSimplesNacional'] = true;
            $viewModel['idcstcofins'] = "14";
            $viewModel['idcstipi'] = "14";
            $viewModel['idcstpis'] = "14";
            $viewModel['cofins'] = "0.00";
            $viewModel['ipi'] = "0.00";
            $viewModel['pis'] = "0.00";  
            $viewModel['icms'] = ($viewModel['icms'] == null ? "0.00" : $viewModel['icms']);
        }
    }

    
    protected function obterFiltros(){
        return array(ProdutoConstans::codigo => "Código", ProdutoConstans::descricao => "Descrição", ProdutoConstans::codigoReduzido => "Código reduzido");
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();

        switch ($request->obterIdFiltro()) {
            case ProdutoConstans::codigo:
                if($parametro > 0)
                    $request->pAnd('produto.id', $parametro);
                break;
            case ProdutoConstans::descricao:
                    $request->pAndLike('descricao', $parametro);
                break;
            case ProdutoConstans::codigoReduzido:
                    $request->pAndLike('codigoreduzido', $parametro);
                break;                
            default:
                break;
        }

        return $this->getObtergrid($request->obterId(), $request);
    }
}
