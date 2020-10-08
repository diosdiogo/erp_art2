<?php

namespace App\Http\Controllers\Sistema\Financeiro\ContaReceber;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Enums\FinanceiroContaReceberSituacaoEnum;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

class FinanceiroContaReceberController extends GridUpdateBaseController
{
    protected $pasta = "financeiro\\ContaReceber";
    protected $contaReceberItens = "contaReceberItens";
    protected $valorTotal = "valortotal";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function acertarEntidade(&$viewModel){
        $viewModel['idsituacao'] = $this->contaReceberPaga() ? FinanceiroContaReceberSituacaoEnum::PAGA : FinanceiroContaReceberSituacaoEnum::ABERTO; 
    }

    public function getObtercontareceberitens(){
        return collect($this->obterContaReceberItensInterno())->values()->toArray();
    }

    private function obterContaReceberItensInterno(){
        return $this->updateViewModel()->get($this->contaReceberItens);
    }

    private function contaReceberPaga(){
        return $this->obterValorTotalItens() == $this->updateViewModel()[$this->valorTotal] && $this->obterValorTotalItens() > 0;
    }

    private function obterValorTotalItens(){
        return collect($this->obterContaReceberItensInterno())->sum($this->valorTotal);
    }

    protected function obterFiltros(){
        return array(1 => "Código", 2 => "Descrição");
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();
        
        switch ($request->obterIdFiltro()) {
            case 1:
                    $request->pAnd('financeirocontareceber.id', $parametro != "" ? $parametro : $request->obterId());
                break;
            case 2:
                    $request->pAndLike('descricao', $parametro);
                break;
        }

        return $this->getObtergrid($request->obterId(), $request);
    }
}