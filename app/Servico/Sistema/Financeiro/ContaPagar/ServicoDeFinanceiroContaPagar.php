<?php
namespace App\Servico\Sistema\Financeiro\ContaPagar;

use Carbon\Carbon;
use App\Enums\FinanceiroMovimentoTipoEnum;
use App\Enums\FinanceiroContaGerencialEnum;
use App\Enums\FinanceiroLancamentoTipoEnum;
use App\Enums\FinanceiroContaPagarSituacaoEnum;
use App\Enums\FinanceiroLancamentoTipoLancamentoTipoEnum;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamento;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagar;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagarItem;
use App\Repositorio\Sistema\Financeiro\FormaRecebimento\RepositorioDeFinanceiroFormaRecebimento;

class ServicoDeFinanceiroContaPagar 
{
    public function gerarContaPagar($venda){
        $repositorioDeFinanceiroFormaRecebimento = new RepositorioDeFinanceiroFormaRecebimento();

        $parcelasItens = $venda->parcelaitens;
        $parcelasItens->each(function($item, $key) use(&$venda, &$repositorioDeFinanceiroFormaRecebimento) {
            $financeiroContaPagar = new FinanceiroContaPagar();
            $financeiroContaPagar->idempresa = $venda->idempresa;
            $financeiroContaPagar->descricao = "PEDIDO DE VENDA CÓDIGO: $venda->id - PARCELA: $item->parcela";
            $financeiroContaPagar->observacao = "PARCELA: $item->parcela   - OBSERVAÇÃO DA VENDA: " . $venda->observacao;
            $financeiroContaPagar->datavencimento = "$item->datavencimento";
            $financeiroContaPagar->valortotal = $item->valor;
            $financeiroContaPagar->idfinanceirocontagerencial = FinanceiroContaGerencialEnum::VENDA;
            $financeiroContaPagar->documento = $venda->id;
            if(starts_with($item->parcela, '1/')){
                $primeiraParcela = $repositorioDeFinanceiroFormaRecebimento->obterParaContasReceberDiaPrimeiraParcela($venda->idformarecebimentoitem, $venda->idformarecebimento) == 0;
                if($primeiraParcela){
                    $this->gerarContaPagarItemVenda($financeiroContaPagar, $venda, $item);
                }else
                    $financeiroContaPagar->save();
            }else
                $financeiroContaPagar->save();
        });
        
    }

    private function gerarContaPagarItemVenda($financeiroContaPagar, $venda, $item){
        $financeiroContaPagar->alterarSituacaoPaga();
        $financeiroContaPagar->save();
        $financeiroContaPagarItem = new FinanceiroContaPagarItem();
        $financeiroContaPagarItem->ordem = 1;
        $financeiroContaPagarItem->idfinanceirocontapagar = $financeiroContaPagar->id;
        $financeiroContaPagarItem->idformarecebimento = $venda->idformarecebimento;
        $financeiroContaPagarItem->idfinanceiroconta = 1;
        $financeiroContaPagarItem->jurosmoeda = 0;
        $financeiroContaPagarItem->descontomoeda = 0;
        $financeiroContaPagarItem->valortotal = $item->valor;
        $financeiroContaPagarItem->datapago = Carbon::now()->toDateString();
        $financeiroContaPagarItem->save();
        $this->gerarFinanceiroLancamento($financeiroContaPagar, $venda, $item->valor, $financeiroContaPagarItem->datapago);
    }

    public function gerarContaPagarItemFinanceiroLancamento($financeiroLancamento){
        $financeiroContaPagarItem = new FinanceiroContaPagarItem();
        $financeiroContaPagarItem->ordem = 1;
        $financeiroContaPagarItem->idfinanceirocontapagar = $financeiroLancamento->numerodocumento;
        $financeiroContaPagarItem->idformarecebimento = $financeiroLancamento->idfinanceiroformarecebimento;
        $financeiroContaPagarItem->idfinanceiroconta = 1;
        $financeiroContaPagarItem->jurosmoeda = 0;
        $financeiroContaPagarItem->descontomoeda = 0;
        $financeiroContaPagarItem->valortotal = $financeiroLancamento->valor;
        $financeiroContaPagarItem->datapago = Carbon::now()->toDateString();
        $financeiroContaPagarItem->save();

        $this->alterarSituacaoContaPagarPaga($financeiroLancamento->numerodocumento, $financeiroLancamento->valor);
    }
    
    public function alterarSituacaoContaPagarPaga($id, $valorTotal){
        $financeiroContaPagar = FinanceiroContaPagar::where('id', $id)->first();
        if($financeiroContaPagar->valortotal == $valorTotal){
            $financeiroContaPagar->alterarSituacaoPaga();
            $financeiroContaPagar->save();
        }
    }

    private function gerarFinanceiroLancamento($financeiroContaPagar, $venda, $valor,$dataLancamento){
        $financeiroLancamento = new FinanceiroLancamento();
        $financeiroLancamento->obterParaVenda();
        $financeiroLancamento->idempresa = $financeiroContaPagar->idempresa;
        $financeiroLancamento->observacao = $financeiroContaPagar->observacao;
        $financeiroLancamento->datalancamento = $dataLancamento;
        $financeiroLancamento->valor = $valor;
        $financeiroLancamento->idfinanceiroformarecebimento = $venda->idformarecebimento;
        $financeiroLancamento->numerodocumento = $venda->id;
        $financeiroLancamento->jurosmoeda = 0;
        $financeiroLancamento->descontomoeda = 0;
        $financeiroLancamento->save();
    }
}