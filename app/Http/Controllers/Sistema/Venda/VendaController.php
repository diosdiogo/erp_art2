<?php

namespace App\Http\Controllers\Sistema\Venda;

use Redirect;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Enums\VendaSituacaoEnum;
use App\Extension\CommonExtension;
use App\Models\Sistema\Produto\Produto;
use App\Helper\Controller\HelperDropDownList;
use App\Servico\Sistema\Venda\ServicoDeVenda;
use App\Helper\Arquivo\HelperDeImpressaoCupom;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Servico\Sistema\Financeiro\ContaReceber\ServicoDeFinanceiroContaReceber;
use App\Servico\Sistema\Financeiro\FormaRecebimento\ServicoDeFinanceiroFormaRecebimento;

class VendaController extends GridUpdateBaseController
{
    protected $pasta = "venda";
    protected $vendaitens = "vendaitens";
    protected $parcelaitens = "parcelaitens";
    protected $servicoDeVenda;
    protected $servicoDeFinanceiroFormaRecebimento;

    public function __construct()
    {
        parent::__construct($this->pasta);
        $this->servicoDeVenda = new ServicoDeVenda($this->updateViewModel());
        $this->servicoDeFinanceiroFormaRecebimento = new ServicoDeFinanceiroFormaRecebimento($this);
    }

    protected function obterParametroGridManual(){
        $lancamentos = collect($this->registrosObter->toArray());
        $totalConcluida = $lancamentos->where('idvendasituacao', VendaSituacaoEnum::CONCLUIDA)->sum('valortotal');
        $totalAberta = $lancamentos->where('idvendasituacao', VendaSituacaoEnum::ABERTA)->sum('valortotal');
        $total = $lancamentos->sum('valortotal');

        return array(
            'total' => CommonExtension::formatarParaMoeda($total),
            'totalAberta' => CommonExtension::formatarParaMoeda($totalAberta),
            'totalConcluida' => CommonExtension::formatarParaMoeda($totalConcluida),
        );
    }

    public function getObterproduto(Request $request){
        return HelperDropDownList::obterProduto(Produto::class, $request);
    }

    public function postInserirvendaitem(Request $request){
        $viewModel = $request->all();
        $idProduto = $viewModel['idproduto'];
        $quantidade = $viewModel['quantidade'];

        if($idProduto && $idProduto > 0 && $quantidade && $quantidade > 0){
            $viewModel['valorunitario'] = $this->obterValorProduto($idProduto);
            $id = collect($this->servicoDeVenda->obterVendaItens())->max('id') + 1;
            $viewModel['id'] = $id;
            $viewModel['valortotal'] = $this->calcularValorTotalVendaItem($viewModel);
            $this->adicionar($this->vendaitens, $viewModel);
            return $viewModel;
        }
    }

    private function obterValorProduto($id){
        return Produto::select('preco')->where('id', $id)->first()->preco;
    }

    public function postAlterarvalorparcela(Request $request){
        $viewModel = $request->all();
        $this->servicoDeFinanceiroFormaRecebimento->alterarValorParcela($viewModel);
        $this->servicoDeFinanceiroFormaRecebimento->recalcularParcelas($viewModel, $this->obterValorTotalVenda());
    }

    public function postAlterarparcelaespecie(Request $request){
        $viewModel = $request->all();
        $this->servicoDeFinanceiroFormaRecebimento->alterarValorParcela($viewModel);
    }

    public function postAlterarparcelaparcela(Request $request){
        $viewModel = $request->all();
        $evento = substr($viewModel['evento'], 0, 22) == 'parcela_datavencimento';
        $this->servicoDeFinanceiroFormaRecebimento->alterarValorParcela($viewModel, null, $evento);
    }

    private function calcularValorTotalVendaItem($viewModel){
        return ($viewModel['quantidade'] * CommonExtension::formatarTextoParaDecimal($viewModel['valorunitario'])) / 100;
    }

    private function obterValorTotalVenda(){
        return str_replace(",", "." ,collect($this->servicoDeVenda->obterVendaItens())->sum('valortotal'));
    }

    public function getObtervalores(){
        return $this->servicoDeVenda->obterValores();
    }

    public function getObtervalortotal(){
        return CommonExtension::formatarParaMoedaDecimal($this->obterValorTotalVenda());
    }

    public function getObteritens(){
        return $this->servicoDeVenda->obterItens();
    }

    protected function acertarEntidade(&$viewModel){
        $viewModel['idtransportadora'] = 1;
        $viewModel['idpessoavendedor'] = 1;
        $viewModel['valortotal'] = CommonExtension::removerVirgulaPorPonto($this->getObtervalortotal());
    }

    private function obterParcelaItensInterno(){
        return $this->updateViewModel()->get($this->parcelaitens);
    }

    public function getObtervalortotalparcelas(){
        $valortotalpagar = $this->servicoDeVenda->obterValores()['valortotalpagar'];
        $valorPago = collect($this->obterParcelaItensInterno())->sum('valor');
        $valorTroco = floatval($valortotalpagar) - floatval(CommonExtension::formatarTextoParaDecimal($valorPago));

        return array(
            'valorpacela' => $valorPago,
            'troco' =>  $valorTroco < 0 ? ($valorTroco * -1) : "0",
            'valorareceber' => $valorTroco < 0 ? 0 : $valorTroco
        );
    }

    public function eventoDepoisInserirAlterar($model, $acao, $viewModel){
        if($viewModel['faturar']){
            $model->alterarSituacaoParaVendaConcluida();
            $servicoDeFinanceiroContaReceber = new ServicoDeFinanceiroContaReceber();
            $servicoDeFinanceiroContaReceber->gerarContaReceber($model);
            $model->save();
        }
    }

    protected function concluirEdicacao($id){
        return redirect(strtolower($this->rotaAcao) . '/inserir');
    }
}
