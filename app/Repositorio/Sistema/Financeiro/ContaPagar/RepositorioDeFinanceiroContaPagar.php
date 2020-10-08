<?php

namespace App\Repositorio\Sistema\Financeiro\ContaPagar;

use DB;
use App\Repositorio\BaseRepository;
use App\Extension\CommonExtension;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamento;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagar;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagarSituacao;

class RepositorioDeFinanceiroContaPagar extends BaseRepository
{
    protected $contaPagarParcelaItens = "contaPagarParcelaItens";
    protected $chaveRelacao = "contaPagarItens";
    

    public function __construct()
    {
        parent::__construct(FinanceirocontaPagar::class);
    }

    public function obterParaAlterar($id){
        $financeirocontaPagar = $this->obter($id);
        $itens = collect($financeirocontaPagar->contaPagarItens);
        $financeirocontaPagar['descricaoSituacao'] = $financeirocontaPagar->Situacao->descricao;

        if($itens->count()){
            $itens->each(function ($item, $key) use (&$financeirocontaPagar) {
                $financeiroConta = $item->financeiroConta;
                $financeirocontaPagar[$this->chaveRelacao][$key]['descricaofinanceiroconta'] = CommonExtension::adicionarCodigoEDescricao($financeiroConta);
                $financeiroFormaRecebimento = $item->financeiroFormaRecebimento;
                $financeirocontaPagar[$this->chaveRelacao][$key]['descricaofinanceiroformarecebimento'] = CommonExtension::adicionarCodigoEDescricao($financeiroFormaRecebimento);
            });
        }

        $financeirocontaPagar[$this->chaveRelacao] = $financeirocontaPagar[$this->chaveRelacao]->toArray();

        return $financeirocontaPagar;
    }

    public function obterGrid(ParametrosGrid $parametrosGrid){
        $parametrosGrid->pPadrao("financeirocontapagar");
        
        return $this->model
        ->select(
            'financeirocontapagar.id',
            'financeirocontapagar.valortotal',
            'financeirocontapagar.descricao',
            'financeirocontapagar.idsituacao',
            DB::raw("CASE WHEN financeirocontapagar.datavencimento < now() AND financeirocontapagar.idsituacao != 2 THEN '3' ELSE financeirocontapagar.idsituacao END as idsituacao"),
            DB::raw("CASE WHEN financeirocontapagar.datavencimento < now() AND financeirocontapagar.idsituacao != 2 THEN 'VENCIDA' ELSE financeirocontapagarsituacao.descricao END as situacao"))
        ->leftJoin("financeirocontapagarsituacao", "financeirocontapagarsituacao.id", '=', 'financeirocontapagar.idsituacao')
        ->whereRaw($parametrosGrid->expressao)
        ->get();
    }
}