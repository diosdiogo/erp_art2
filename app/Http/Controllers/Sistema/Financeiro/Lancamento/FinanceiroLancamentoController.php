<?php

namespace App\Http\Controllers\Sistema\Financeiro\Lancamento;

use App\Http\Requests;
use App\Enums\AcaoEnum;
use Illuminate\Http\Request;
use App\Extension\CommonExtension;
use App\Enums\FinanceiroLancamentoTipoEnum;
use App\Enums\FinanceiroContaPagarSituacaoEnum;
use App\Enums\FinanceiroContaReceberSituacaoEnum;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagar;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceber;
use App\Servico\Sistema\Financeiro\ContaPagar\ServicoDeFinanceiroContaPagar;
use App\Servico\Sistema\Financeiro\ContaReceber\ServicoDeFinanceiroContaReceber;

class FinanceiroLancamentoController extends GridUpdateBaseController
{
    protected $pasta = "financeiro\\lancamento";
    protected $idfinanceirolancamentotipo = "idfinanceirolancamentotipo";
    protected $parametroInserir = array();

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function obterParametroGridManual(){
        $lancamentos = collect($this->registrosObter->toArray());
        $receita = $lancamentos->whereIn($this->idfinanceirolancamentotipo, array(FinanceiroLancamentoTipoEnum::RECEBIMENTO, FinanceiroLancamentoTipoEnum::CONTARECEBER))->sum('valor');
        $despesa = $lancamentos->whereIn($this->idfinanceirolancamentotipo, array(FinanceiroLancamentoTipoEnum::PAGAMENTO, FinanceiroLancamentoTipoEnum::CONTAPAGAR))->sum('valor');
        $total = $receita - $despesa;

        return array(
            'receita' => CommonExtension::formatarParaMoeda($receita),
            'despesa' => CommonExtension::formatarParaMoeda($despesa),
            'total' => CommonExtension::formatarParaMoeda($total), 
        );
    }

    public function getObterfinanceirolancamentopartial(Request $request){
        $viewModel = $request->all();
        $id = $viewModel ['id'];
        if($id > 0){
            switch ($id) {
                case FinanceiroLancamentoTipoEnum::PAGAMENTO:
                case FinanceiroLancamentoTipoEnum::RECEBIMENTO:
                    return $this->obterView("_updatefinanceirolancamentocomum", $this->updateViewModel()->all());
                case FinanceiroLancamentoTipoEnum::TRANSFERENCIA:
                    return $this->obterView("_updatefinanceirolancamentotransferencia", $this->updateViewModel()->all());
                case FinanceiroLancamentoTipoEnum::CONTAPAGAR:
                    return $this->obterView("_updatefinanceirolancamentocontapagar", $this->updateViewModel()->all());
                case FinanceiroLancamentoTipoEnum::CONTARECEBER:
                    return $this->obterView("_updatefinanceirolancamentocontareceber", $this->updateViewModel()->all());
            }
        }
    }

    public function getObterdocumento(Request $request){
        $viewModel = $request->all();
        $id = $viewModel ['id'];
        if($id > 0){
            switch ($id) {
                case FinanceiroLancamentoTipoEnum::CONTAPAGAR:
                    return $this->obterBasicoWhere(FinanceiroContaPagar::class, $request, "idsituacao =" . FinanceiroContaPagarSituacaoEnum::ABERTO);
                case FinanceiroLancamentoTipoEnum::CONTARECEBER:
                    return $this->obterBasicoWhere(FinanceiroContaReceber::class, $request, "idsituacao = " . FinanceiroContaReceberSituacaoEnum::ABERTO);
            }
        }
    }

    public function getObterfinanceirocontareceber(Request $request){
        return $this->obterDinamicoWhere(FinanceiroContaReceber::class, $request, ['valortotal, idsituacao'],' idsituacao = ' . FinanceiroContaReceberSituacaoEnum::ABERTO);
    }

    public function eventoDepoisInserirAlterar($model, $acao, $viewModel){
        switch ($model->idfinanceirolancamentotipo) {
            case FinanceiroLancamentoTipoEnum::CONTARECEBER:
                $servicoDeFinanceiroContaReceber = new ServicoDeFinanceiroContaReceber();
                $servicoDeFinanceiroContaReceber->gerarContaReceberItemFinanceiroLancamento($model);
                break;
            case FinanceiroLancamentoTipoEnum::CONTAPAGAR:
                $servicoDeFinanceiroContaPagar = new ServicoDeFinanceiroContaPagar();
                $servicoDeFinanceiroContaPagar->gerarContaPagarItemFinanceiroLancamento($model);
                break;
        }
    }

    protected function obterParametrosInserir(){
        return $this->parametroInserir;
    }

    public function getRecalcularvalores(Request $request){
        $jurosMoeda = CommonExtension::formatarTextoParaDecimal($request['jurosmoeda']);
        $descontoMoeda = CommonExtension::formatarTextoParaDecimal($request['descontomoeda']);
        $valor = CommonExtension::formatarTextoParaDecimal($request['valor']);
        $valorTotalDocumento = $this->updateViewModel()['valortotalreceber'];
        $valorTotalPago = CommonExtension::formatarTextoParaDecimal($valor - $descontoMoeda + $jurosMoeda);
        
        $valorTroco = $valorTotalPago - $valorTotalDocumento;

        
        return array(
            'valorTotal' => $valorTotalPago,
            'valortroco' => $valorTroco < 0 ? 0 : $valorTroco,
            'valorareceber' => $valorTroco < 0 ? ($valorTroco * -1) : "0"
        );
    }

    public function getReceber(Request $request){
        $financeiroContaReceber = FinanceiroContaReceber::where('id', $request['id'])->first();

        $retorno = $this->validarEntidadeGrid($financeiroContaReceber, $financeiroContaReceber->validarReceber());
        
        if(array_key_exists('erro', $retorno))
            return $retorno['retorno'];

        $this->parametroInserir = array(
            'idfinanceirolancamentotipo' => FinanceiroLancamentoTipoEnum::CONTARECEBER,
            'numerodocumento' => $request['id'],
            'descricaoDocumento' => CommonExtension::adicionarCodigoEDescricao($financeiroContaReceber),
            'valor' =>  $financeiroContaReceber['valortotal'],
            'jurosmoeda' => '0,00',
            'descontomoeda' => '0,00',
            'datavencimento' => $financeiroContaReceber['datavencimento'],
            'valortotalreceber' => $financeiroContaReceber['valortotal'],
            'observacao' => $financeiroContaReceber['observacao'],
        );

        return $this->getInserir();
    }

    public function getPagar(Request $request){
        $financeiroContaPagar = FinanceiroContaPagar::where('id', $request['id'])->first();

        $retorno = $this->validarEntidadeGrid($financeiroContaPagar, $financeiroContaPagar->validarPagar());
        
        if(array_key_exists('erro', $retorno))
            return $retorno['retorno'];

        $this->parametroInserir = array(
            'idfinanceirolancamentotipo' => FinanceiroLancamentoTipoEnum::CONTAPAGAR,
            'numerodocumento' => $request['id'],
            'descricaoDocumento' => CommonExtension::adicionarCodigoEDescricao($financeiroContaPagar),
            'valor' =>  $financeiroContaPagar['valortotal'],
            'jurosmoeda' => '0,00',
            'descontomoeda' => '0,00',
            'datavencimento' => $financeiroContaPagar['datavencimento'],
            'valortotalreceber' => $financeiroContaPagar['valortotal'],
            'observacao' => $financeiroContaPagar['observacao'],
        );

        return $this->getInserir();
    }
}