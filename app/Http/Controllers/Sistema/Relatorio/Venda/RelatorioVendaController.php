<?php
namespace App\Http\Controllers\Sistema\Relatorio\Venda;

use App\Http\Requests;
use App\Enums\UnidadeMedida;
use Illuminate\Http\Request;
use App\Models\Sistema\Transportadora\Transportadora;
use App\Helper\Controller\HelperDropDownList;
use App\Http\Controllers\Behavior\BaseAuthController;
use App\Repositorio\Sistema\Venda\RepositorioDeVenda;
class RelatorioVendaController extends BaseAuthController
{
    protected $pasta = "relatorio\\venda";
    protected $gridView = "relatorio.venda.relatoriovendapadrao";
    protected $inicializarModel = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObtertransportadora(Request $request){
        return HelperDropDownList::obter(Transportadora::class, $request);
    }

    public function getValidargerarrelatorio(Request $request){
        $viewModel = $request->all();
        $romaneios = $this->obterRomaneios($viewModel);
        return $romaneios->count();
    }

    public function obterRomaneios($viewModel){
        $romaneios = null;
        if($viewModel != null){
            $repositorioDeVenda = new RepositorioDeVenda();
            $romaneios = collect($repositorioDeVenda->obterImpressaoRomaneios($viewModel));
        }

        return $romaneios;
    }

    public function getImprimir(Request $request){
        $viewModel = $request->all();
        if($viewModel != null){
            $retorno = collect($viewModel);
            $romaneios = $this->obterRomaneios($viewModel);
            $retorno = $retorno->merge(['produtos' => $romaneios]);
            $quantidadetotalpecas = $romaneios->where('idunidademedida', UnidadeMedida::UNIDADE)->sum("quantidade");
            $quantidadetotalcaixas = $romaneios->where('idunidademedida', UnidadeMedida::CAIXA)->sum("quantidade");
            $retorno = $retorno->merge(['quantidadetotalpecas' => $quantidadetotalpecas]);
            $retorno = $retorno->merge(['quantidadetotalcaixas' => $quantidadetotalcaixas]);
            $retorno = $retorno->merge(['descricaotransportadora' => $romaneios->first()->descricaotransportadora]);

            if($viewModel['tipo'] == 2){
                $retorno = $retorno->merge(['produtosGrupo' => $romaneios->groupBy(function ($item, $key) {
                    return $item->idvenda;
                })]);

                return $this->obterViewPDF(view("relatorio.venda.impressaovendafrigorificoromaneios", $retorno), false);
            }else{
                return $this->obterViewPDF(view("relatorio.venda.impressaovendafrigorificoromaneiospecas", $retorno), false);
            }
        }

        return "";
    }
}