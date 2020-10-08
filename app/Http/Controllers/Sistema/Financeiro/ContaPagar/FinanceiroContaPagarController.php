<?php

namespace App\Http\Controllers\Sistema\Financeiro\ContaPagar;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\FinanceiroContaPagarSituacaoEnum;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

class FinanceiroContaPagarController extends GridUpdateBaseController
{
    protected $pasta = "financeiro\\ContaPagar";
    protected $contaReceberItens = "contaPagarItens";
    protected $valorTotal = "valortotal";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function acertarEntidade(&$viewModel){
        $viewModel['idsituacao'] = $this->contaReceberPaga() ? FinanceiroContaPagarSituacaoEnum::PAGA : FinanceiroContaPagarSituacaoEnum::ABERTO; 
    }

    public function getObtercontapagaritens(){
        return collect($this->obterContaPagarItensInterno())->values()->toArray();
    }

    private function obterContaPagarItensInterno(){
        return $this->updateViewModel()->get($this->contaReceberItens);
    }

    private function contaReceberPaga(){
        return $this->obterValorTotalItens() == $this->updateViewModel()[$this->valorTotal] && $this->obterValorTotalItens() > 0;
    }

    private function obterValorTotalItens(){
        return collect($this->obterContaPagarItensInterno())->sum($this->valorTotal);
    }

    protected function obterFiltros(){
        return array(1 => "Código", 2 => "Descrição");
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();
        
        switch ($request->obterIdFiltro()) {
            case 1:
                    $request->pAnd('financeirocontapagar.id', $parametro != "" ? $parametro : $request->obterId());
                break;
            case 2:
                    $request->pAndLike('descricao', $parametro);
                break;
        }

        return $this->getObtergrid($request->obterId(), $request);
    }
}