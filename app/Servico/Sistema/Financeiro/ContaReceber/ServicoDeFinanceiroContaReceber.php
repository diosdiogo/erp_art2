<?php
namespace App\Servico\Sistema\Financeiro\ContaReceber;

use Carbon\Carbon;
use App\Enums\FinanceiroMovimentoTipoEnum;
use App\Enums\FinanceiroContaGerencialEnum;
use App\Enums\FinanceiroLancamentoTipoEnum;
use App\Enums\FinanceiroContaReceberSituacaoEnum;
use App\Enums\FinanceiroLancamentoTipoLancamentoTipoEnum;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamento;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceber;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceberItem;
use App\Repositorio\Sistema\Financeiro\FormaRecebimento\RepositorioDeFinanceiroFormaRecebimento;

class ServicoDeFinanceiroContaReceber
{
    public function cancelarContaReceber($venda){
        $contasReceberSQL = FinanceiroContaReceber::where('documento', $venda->id);
        $contasReceber = $contasReceberSQL->get();

        $contasReceber->each(function ($item, $key) {
            $financeiro = FinanceiroLancamento::where('numerodocumento', $item->id);
            if($financeiro != null > 0){
                $financeiro->delete();
            }
        });

        $contasReceberSQL->delete();
    }

    public function gerarContaReceber($venda){
        $repositorioDeFinanceiroFormaRecebimento = new RepositorioDeFinanceiroFormaRecebimento();

        $parcelasItens = $venda->parcelaitens;
        $parcelasItens->each(function($item, $key) use(&$venda, &$repositorioDeFinanceiroFormaRecebimento) {
            $financeiroContaReceber = new FinanceiroContaReceber();
            $financeiroContaReceber->idempresa = $venda->idempresa;
            $financeiroContaReceber->descricao = "PEDIDO DE VENDA CÓDIGO: $venda->id - PARCELA: $item->parcela";
            $financeiroContaReceber->observacao = "PARCELA: $item->parcela   - OBSERVAÇÃO DA VENDA: " . $venda->observacao;
            $financeiroContaReceber->datavencimento = "$item->datavencimento";
            $financeiroContaReceber->valortotal = $item->valor;
            $financeiroContaReceber->idfinanceirocontagerencial = FinanceiroContaGerencialEnum::VENDA;
            $financeiroContaReceber->documento = $venda->id;
            if(starts_with($item->parcela, '1/')){
                $primeiraParcela = $repositorioDeFinanceiroFormaRecebimento->obterParaContasReceberDiaPrimeiraParcela($venda->idformarecebimentoitem, $venda->idformarecebimento) == 0;
                if($primeiraParcela){
                    $this->gerarContaReceberItemVenda($financeiroContaReceber, $venda, $item);
                }else
                    $financeiroContaReceber->save();
            }else
                $financeiroContaReceber->save();
        });

    }

    private function gerarContaReceberItemVenda($financeiroContaReceber, $venda, $item){
        $financeiroContaReceber->alterarSituacaoPaga();
        $financeiroContaReceber->save();
        $financeiroContaReceberItem = new FinanceiroContaReceberItem();
        $financeiroContaReceberItem->ordem = 1;
        $financeiroContaReceberItem->idfinanceirocontareceber = $financeiroContaReceber->id;
        $financeiroContaReceberItem->idformarecebimento = $venda->idformarecebimento;
        $financeiroContaReceberItem->idfinanceiroconta = 1;
        $financeiroContaReceberItem->jurosmoeda = 0;
        $financeiroContaReceberItem->descontomoeda = 0;
        $financeiroContaReceberItem->valortotal = $item->valor;
        $financeiroContaReceberItem->datapago = Carbon::now()->toDateString();
        $financeiroContaReceberItem->save();
        $this->gerarFinanceiroLancamento($financeiroContaReceber, $venda, $item->valor, $financeiroContaReceberItem->datapago);
    }

    public function gerarContaReceberItemFinanceiroLancamento($financeiroLancamento){
        $financeiroContaReceberItem = new FinanceiroContaReceberItem();
        $financeiroContaReceberItem->ordem = 1;
        $financeiroContaReceberItem->idfinanceirocontareceber = $financeiroLancamento->numerodocumento;
        $financeiroContaReceberItem->idformarecebimento = $financeiroLancamento->idfinanceiroformarecebimento;
        $financeiroContaReceberItem->idfinanceiroconta = 1;
        $financeiroContaReceberItem->jurosmoeda = 0;
        $financeiroContaReceberItem->descontomoeda = 0;
        $financeiroContaReceberItem->valortotal = $financeiroLancamento->valor;
        $financeiroContaReceberItem->datapago = Carbon::now()->toDateString();
        $financeiroContaReceberItem->save();

        $this->alterarSituacaoContaReceberPaga($financeiroLancamento->numerodocumento, $financeiroLancamento->valor);
    }

    public function alterarSituacaoContaReceberPaga($id, $valorTotal){
        $financeiroContaReceber = FinanceiroContaReceber::where('id', $id)->first();
        if($financeiroContaReceber->valortotal == $valorTotal){
            $financeiroContaReceber->alterarSituacaoPaga();
            $financeiroContaReceber->save();
        }
    }

    private function gerarFinanceiroLancamento($financeiroContaReceber, $venda, $valor,$dataLancamento){
        $financeiroLancamento = new FinanceiroLancamento();
        $financeiroLancamento->obterParaVenda();
        $financeiroLancamento->idempresa = $financeiroContaReceber->idempresa;
        $financeiroLancamento->observacao = $financeiroContaReceber->observacao;
        $financeiroLancamento->datalancamento = $dataLancamento;
        $financeiroLancamento->valor = $valor;
        $financeiroLancamento->idfinanceiroformarecebimento = $venda->idformarecebimento;
        $financeiroLancamento->numerodocumento = $venda->id;
        $financeiroLancamento->jurosmoeda = 0;
        $financeiroLancamento->descontomoeda = 0;
        $financeiroLancamento->save();
    }
}