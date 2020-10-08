<?php

namespace App\Repositorio\Sistema\Financeiro\Lancamento;

use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use App\Enums\FinanceiroLancamentoTipoEnum;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamento;

class RepositorioDeFinanceiroLancamento extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(FinanceiroLancamento::class);
    }

    public function obterParaAlterar($id){
        $lancamento = $this->obter($id);
        $lancamento['descricaoDocumento'] = $this->obterDescricaoLancamento($lancamento);
        return $lancamento;
    }

    private function obterDescricaoLancamento($lancamento){
        switch ($lancamento->idfinanceirolancamentotipo) {
            case FinanceiroLancamentoTipoEnum::CONTARECEBER:
                $contaReceber = $lancamento->financeiroContaReceber();
                return CommonExtension::adicionarCodigoEDescricao($contaReceber);
            case FinanceiroLancamentoTipoEnum::CONTAPAGAR:
                $contaPagar = $lancamento->financeiroContaPagar();
                return CommonExtension::adicionarCodigoEDescricao($contaPagar);
        }

        return "";
    }


    public function obterGrid(ParametrosGrid $request){
        return $this->obterComJoin($request);
    }

    private function obterComJoin($request = ''){
          $request->pPadrao("financeirolancamento");
          return $this->model
                ->leftJoin("financeirolancamentotipo", "financeirolancamento.idfinanceirolancamentotipo", '=', 'financeirolancamentotipo.id')
                ->leftJoin("financeirolancamentotipolancamento", "financeirolancamento.idlancamentotipolancamento", '=', 'financeirolancamentotipolancamento.id')
                ->select('financeirolancamento.numerodocumento', 'financeirolancamento.id', 'financeirolancamento.idfinanceirolancamentotipo', 'financeirolancamento.valor',
                        'financeirolancamento.observacao', 'financeirolancamentotipo.descricao', 'financeirolancamentotipolancamento.descricao AS lacamentotipo')
                ->whereRaw($request->expressao)
                ->get();
    }

    public function obterParaDashboard(){
        $idfinanceirolancamentotipo = "idfinanceirolancamentotipo";
        $obter =  $this->obterComJoin(new ParametrosGrid());
        $lancamentos = collect($obter);
        $receita = $lancamentos->where($idfinanceirolancamentotipo, FinanceiroLancamentoTipoEnum::RECEBIMENTO)->sum('valor');
        $despesa = $lancamentos->where($idfinanceirolancamentotipo, FinanceiroLancamentoTipoEnum::PAGAMENTO)->sum('valor');
        $total = $receita - $despesa;

        return array(
            'receita' => $receita,
            'despesa' => $despesa,
            'total' => $total, 
        );
    }
}