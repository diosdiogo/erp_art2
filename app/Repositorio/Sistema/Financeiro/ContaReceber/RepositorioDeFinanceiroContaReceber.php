<?php

namespace App\Repositorio\Sistema\Financeiro\ContaReceber;

use DB;
use App\Repositorio\BaseRepository;
use App\Extension\CommonExtension;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamento;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceber;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceberSituacao;

class RepositorioDeFinanceiroContaReceber extends BaseRepository
{
    protected $contaReceberParcelaItens = "contaReceberParcelaItens";
    protected $chaveRelacao = "contaReceberItens";
    

    public function __construct()
    {
        parent::__construct(FinanceiroContaReceber::class);
    }

    public function obterParaAlterar($id){
        $financeiroContaReceber = $this->obter($id);
        $itens = collect($financeiroContaReceber->contaReceberItens);
        
        $situacao = $financeiroContaReceber->Situacao;
        $financeiroContaReceber['descricaoSituacao'] = $situacao != null ? $situacao->descricao : "EM ABERTO";
        $itens->each(function ($item, $key) use (&$financeiroContaReceber) {
            $financeiroConta = $item->financeiroConta;
            $financeiroContaReceber[$this->chaveRelacao][$key]['descricaofinanceiroconta'] = CommonExtension::adicionarCodigoEDescricao($financeiroConta);
            $financeiroFormaRecebimento = $item->financeiroFormaRecebimento;
            $financeiroContaReceber[$this->chaveRelacao][$key]['descricaofinanceiroformarecebimento'] = CommonExtension::adicionarCodigoEDescricao($financeiroFormaRecebimento);
        });

        $financeiroContaReceber[$this->chaveRelacao] = $financeiroContaReceber[$this->chaveRelacao]->toArray();

        return $financeiroContaReceber;
    }

    public function obterGrid(ParametrosGrid $parametrosGrid){
        $parametrosGrid->pPadrao("financeirocontareceber");

        return $this->model
        ->select(
            'financeirocontareceber.id',
            'financeirocontareceber.valortotal',
            'financeirocontareceber.descricao',
            'financeirocontareceber.idsituacao',
            DB::raw("CASE WHEN financeirocontareceber.datavencimento < CAST(now() AS DATE) AND financeirocontareceber.idsituacao != 2 THEN '3' ELSE financeirocontareceber.idsituacao END as idsituacao"),
            DB::raw("CASE WHEN financeirocontareceber.datavencimento < CAST(now() AS DATE) AND financeirocontareceber.idsituacao != 2 THEN 'VENCIDA' ELSE financeirocontarecebersituacao.descricao END as situacao"))
        ->leftJoin("financeirocontarecebersituacao", "financeirocontarecebersituacao.id", '=', 'financeirocontareceber.idsituacao')
        ->whereRaw($parametrosGrid->expressao)
        ->get();
    }
}