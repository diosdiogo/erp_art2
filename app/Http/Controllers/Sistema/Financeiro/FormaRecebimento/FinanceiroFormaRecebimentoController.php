<?php
namespace App\Http\Controllers\Sistema\Financeiro\FormaRecebimento;
use \App\Models\Sistema\Financeiro\Conta;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItem;
use Illuminate\Auth\Access\Response;
use App\Extension\MapperExtension;
use App\ViewModel\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItemViewModel;

class FinanceiroFormaRecebimentoController extends GridUpdateBaseController
{
    protected $pasta = "financeiro\\FormaRecebimento";
    private $formarecebimentoitens = "formarecebimentoitens"; 

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function obterParametroAlterar(){
        $updateViewModel = $this->updateViewModel();
        $updateViewModel->merge(array($this->formarecebimentoitens => FinanceiroFormaRecebimentoItem::where('idformarecebimento', $updateViewModel['id'])->get()->toArray()));
    }

    private function obterFormaRecebimentoItens(){
        return $this->updateViewModel()->get($this->formarecebimentoitens);
    }

    public function getObteritens(){
        return collect($this->obterFormaRecebimentoItens())->values()->toArray();
    }

    public function getInserirfinanceiroformarecebimentoitem(){
        return $this->obterView("_updatefinanceiroformarecebimentoitem", FinanceiroFormaRecebimentoItemViewModel::CAMPOS);
    }

    public function postInserirfinanceiroformarecebimentoitem(FinanceiroFormaRecebimentoItemViewModel $request){
        $viewModel = $request->all();
        $id = collect($this->obterFormaRecebimentoItens())->max('id') + 1;
        $viewModel['id'] = $id;
        $this->adicionar($this->formarecebimentoitens, $viewModel);
        return $viewModel;
    }

    public function getAlterarfinanceiroformarecebimentoitem(Request $request){
        $viewModel = $request->all();
        $item = $this->obterUpdateViewModelItem($this->obterFormaRecebimentoItens(), $viewModel);

        return $this->obterView("_updatefinanceiroformarecebimentoitem", $item);
    }

    public function postAlterarfinanceiroformarecebimentoitem(FinanceiroFormaRecebimentoItemViewModel $request){
        $viewModel = $request->all();
        $this->remover($this->formarecebimentoitens, $viewModel['id']);
        $this->adicionar($this->formarecebimentoitens, $viewModel);

        return $viewModel;
    }


    public function postDeletarfinanceiroformarecebimentoitem(Request $request){
        $viewModel = $request->all();
        $this->remover($this->formarecebimentoitens, $viewModel['id']);

        return $viewModel;
    }
}