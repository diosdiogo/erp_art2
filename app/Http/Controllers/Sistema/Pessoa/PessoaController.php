<?php
namespace App\Http\Controllers\Sistema\Pessoa;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Extension\CommonExtension;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Endereco\Cidade;
use App\Constants\Pessoa\PessoaConstants;
use App\Helper\Controller\HelperDropDownList;
use App\ViewModel\Pessoa\UpdatePessoaViewModel;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

class PessoaController extends GridUpdateBaseController
{
    protected $pasta = "pessoa";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObtercidade(Request $request){
        return HelperDropDownList::obter(Cidade::class, $request);
    }
    
    protected function acertarEntidade(&$viewModel){
        $viewModel['cpfoucnpj'] = CommonExtension::removerCNPJ($viewModel['cpfoucnpj']);
    }

    public function getObterdescricaocidade(Request $request){
        $cidades = HelperDropDownList::obterDinamico(Cidade::class, $request, "codigo");
        return $cidades->count() ? $cidades[0] : $cidades;
    }

    protected function obterFiltros(){
        return array(PessoaConstants::codigo => "Código", PessoaConstants::codigoPersonalizado => "Código personalizado",  PessoaConstants::razaoSocial => "Razão social");
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();
    
        switch ($request->obterIdFiltro()) {
            case PessoaConstants::codigo:
                if($parametro > 0)
                    $request->pAnd('pessoa.id', $parametro);
                break;
            case PessoaConstants::codigoPersonalizado:
                    $request->pAndLike('codigopesonalizado', $parametro);
                break;
            case PessoaConstants::razaoSocial:
                    $request->pAndLike('razaosocial', $parametro);
                break;                
            default:
                break;
        }

        return $this->getObtergrid($request->obterId(), $request);
    }
}