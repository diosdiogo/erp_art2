<?php

namespace App\Http\Controllers\Sistema\Venda;

use DB;
use PDF;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Enums\VendaSituacaoEnum;
use App\Extension\CommonExtension;
use App\Constants\Venda\VendaConstans;
use App\Models\Sistema\Produto\Produto;
use App\Servico\Sistema\Venda\ServicoDeVenda;
use App\Helper\Controller\HelperDropDownList;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Servico\Sistema\Fiscal\ServicoDeNotaFiscal;
use App\ViewModel\Sistema\Venda\VendaSimplesItemViewModel;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Servico\Sistema\Financeiro\ContaReceber\ServicoDeFinanceiroContaReceber;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItem;
use App\Models\Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipo;
use App\Servico\Sistema\Financeiro\FormaRecebimento\ServicoDeFinanceiroFormaRecebimento;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceber;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamento;

class VendaSimplesController extends GridUpdateBaseController
{
    protected $pasta = "Venda";
    protected $nomeModel = "Venda";
    protected $nomeUpdateViewModel = "Vendasimples";
    protected $rotaAcao = "vendasimples";
    protected $rotaAcaoErro = "vendasimples";
    protected $vendaitens = "vendaitens";
    protected $parcelaitens = "parcelaitens";
    protected $relatorioVenda = "relatorio.venda.impressaovenda";
    protected $relatorioVendaFrigorifico = "relatorio.venda.impressaovendafrigorifico";
    protected $empresa = "empresas";
    protected $servicoDeFinanceiroFormaRecebimento;
    protected $servicoDeVenda;

    public function __construct()
    {
        parent::__construct($this->pasta);
        $this->servicoDeFinanceiroFormaRecebimento = new ServicoDeFinanceiroFormaRecebimento($this);
        $this->servicoDeVenda = new ServicoDeVenda($this->updateViewModel());
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

    protected function obterParametrosManuais(){
        return [
            'isEmpresaFrigorifico' => $this->sessionProperties->isEmpresaFrigorifico(),
            'isEmpresaMateriasConstrucao' => $this->sessionProperties->isEmpresaMateriasConstrucao()
        ];
    }

    private function obterVendaItens(){
        return $this->updateViewModel()->get($this->vendaitens);
    }

    public function getObteritens(){
        return collect($this->obterVendaItens())->values()->toArray();
    }

    public function getObterparcelaitens(){
        return collect($this->obterParcelaItensInterno())->values()->toArray();
    }

    public function getFormarecebimentoitemgerarparcelas(Request $request){
        $this->servicoDeFinanceiroFormaRecebimento->gerarFormaDeRecebimento($request, $this->obterValorTotalVenda());
    }

    private function obterParcelaItensInterno(){
        return $this->updateViewModel()->get($this->parcelaitens);
    }

    protected function acertarEntidade(&$viewModel){
        $this->servicoDeVenda->validarValorRecebido($viewModel);
        $viewModel['valortotal'] = CommonExtension::removerVirgulaPorPonto($this->getObtervalortotal());
    }

    public function getInserirvendaitem(){
        return $this->obterView("_updatevendasimplesitem", array_merge(VendaSimplesItemViewModel::CAMPOS , $this->obterParametrosManuais()));
    }

    public function getObterproduto(Request $request){
        return HelperDropDownList::obterProduto(Produto::class, $request);
    }

    public function getObterespecie(Request $request){
        return HelperDropDownList::obter(FinanceiroFormaRecebimentoTipo::class, $request);
    }

    public function postInserirvendaitem(VendaSimplesItemViewModel $request){
        $viewModel = $request->all();
        $id = collect($this->obterVendaItens())->max('id') + 1;
        $viewModel['id'] = $id;
        $idProduto = $viewModel['idproduto'];
        $viewModel['valorunitario'] = $this->sessionProperties->isEmpresaFrigorifico() ? CommonExtension::formatarTextoParaDecimal($viewModel['valorunitario']) : $this->obterValorProduto($idProduto);
        $viewModel['valortotal'] = $this->calcularValorTotalVendaItem($viewModel, true);
        $this->adicionar($this->vendaitens, $viewModel);
        return $viewModel;
    }

    private function calcularValorTotalVendaItem($viewModel, $salvar = false){
        $quantidade = ($salvar ?  CommonExtension::formatarTextoParaDecimal($viewModel['quantidade']) : $viewModel['quantidade']);
        $valorTotal = $quantidade * ($viewModel['acrescimomoeda'] - $viewModel['descontomoeda'] + $this->obterValorUnitarioItemPorcentagem($viewModel));
        return $valorTotal > 0 ? str_replace(",", ".", $valorTotal) : 0;
    }

    private function obterValorProduto($id){
        return Produto::select('preco')->where('id', $id)->first()->preco;
    }

    public function getAlterarvendaitem(Request $request){
        $viewModel = $request->all();
        $item = $this->obterUpdateViewModelItem($this->obterVendaItens(), $viewModel);
        $item['valortotal'] = CommonExtension::formatarParaMoedaDecimal($this->calcularValorTotalVendaItem($item, true));
        $item = array_merge($item, array('quantidadeRealQuadrado' => explode(";", $item['quantidadequadradotexto'])));
        return $this->obterView("_updatevendasimplesitem", array_merge($item, $this->obterParametrosManuais()));
    }

    public function postAlterarvendaitem(VendaSimplesItemViewModel $request){
        $viewModel = $request->all();
        $this->remover($this->vendaitens, $viewModel['id']);
        $idProduto = $viewModel['idproduto'];
        $viewModel['valorunitario'] = $this->sessionProperties->isEmpresaFrigorifico() ? CommonExtension::formatarTextoParaDecimal($viewModel['valorunitario']) : $this->obterValorProduto($idProduto);
        $viewModel['valortotal'] = $this->calcularValorTotalVendaItem($viewModel, true);
        $this->adicionar($this->vendaitens, $viewModel);

        return $viewModel;
    }

    public function getObterformarecebimentoitem(Request $request){
        $idformarecebimento = $request['idformarecebimento'];

        if($request != null && $idformarecebimento != null)
            return HelperDropDownList::obterWhere(FinanceiroFormaRecebimentoItem::class, "idformarecebimento = $idformarecebimento");

        return null;
    }

    private function obterValorTotalVenda(){
        return str_replace(",", "." , collect($this->obterVendaItens())->sum('valortotal'));
    }

    public function getObtervalortotal(){
        return CommonExtension::formatarParaMoedaDecimal($this->obterValorTotalVenda());
    }

    public function getCalculardiferencaparcelas(Request $request){
        return $this->servicoDeFinanceiroFormaRecebimento->calcularDiferencaParcelas($this->obterValorTotalVenda(), $this->obterValorTotalParcelaFormatado());
    }

    public function obterValorTotalParcelaFormatado(){
        return collect($this->obterParcelaItensInterno())->map(function ($item) {
            $item['valor'] = CommonExtension::removerVirgulaPorPonto($item['valor']);
            return $item;
        })->sum('valor');
    }

    public function getObtervalortotalparcela(){
        return $this->servicoDeFinanceiroFormaRecebimento->calcularDiferencaParcelas($this->obterValorTotalVenda(), $this->obterValorTotalParcelaFormatado())['diferencia'];
    }

    public function getCalcularvalortotalitem(Request $request){
        return $this->calcularValorTotalVendaItem($request);
    }

    public function postAlterarparcelasvalores(Request $request){
        $viewModel = $request['item'];
        $itens = collect(json_decode($request->all()['itens']));

        $itens->each(function ($item, $key) use(&$viewModel) {
            $this->servicoDeFinanceiroFormaRecebimento->alterarValorParcela((array)$item, $viewModel);
        });

        if(starts_with($viewModel['parcela'], "1/"))
            $this->servicoDeFinanceiroFormaRecebimento->recalcularParcelas((array)$itens[0], $this->getObtervalortotal());
    }

    private function obterValorUnitarioItemPorcentagem($request){
        $desconto = str_replace("%", "", $request['descontoporcentagem']);
        $valorUnitario = $request['valorunitario'];

        if($desconto > 0)
            $valorUnitario = $valorUnitario - ($valorUnitario * ($desconto / 100));

        return $valorUnitario;
    }

    public function postDeletarvendaitem(Request $request){
        $viewModel = $request->all();
        $this->remover($this->vendaitens, $viewModel['id']);

        return $viewModel;
    }

    public function getReabrir(Request $request){
        $id = $request['id'];
        $entidade = $this->model->where('id', $id)->first();

        if($entidade->isSituacaoConcluida()){ // Válidar se existe nota fiscal
            $entidade->alterarSituacaoParaVendaAberta();
            $servicoDeFinanceiroContaReceber = new ServicoDeFinanceiroContaReceber();
            $servicoDeFinanceiroContaReceber->cancelarContaReceber($entidade); // Criar método de cancelarContasReceber/e Financeiro Lancamentos
            $entidade->save();
        }else
            return $this->obterErrorParaGridTemplate($id, $this->retorno("Só é permitido cancelar a venda se não existir nota fiscal e a situação da venda esteja [CONCLUÍDO]"));

        return $this->concluirEdicacao($id);
    }

    public function getFaturar(Request $request){
        $id = $request['id'];
        $entidade = $this->model->where('id', $id)->first();
        $retorno = $this->validarEntidadeGrid($entidade, $entidade->validarFaturar());

        if(array_key_exists('erro', $retorno))
            return $retorno['retorno'];

        $entidade->alterarSituacaoParaVendaConcluida();

        $servicoDeFinanceiroContaReceber = new ServicoDeFinanceiroContaReceber();
        $servicoDeFinanceiroContaReceber->gerarContaReceber($entidade);

        $entidade->save();

        return $retorno;
    }

    public function getObterdiasemanapessoa(Request $request){
        $id = $request['id'];
        if($id > 0 && $id != null){
            return DB::select(DB::raw(@"SELECT descricao FROM pessoa
                LEFT JOIN diadasemana ON diadasemana.id = pessoa.iddiadasemana
                WHERE pessoa.id = $id"));
        }
    }

    public function getImprimir(Request $request){
        $id = $request['id'];
        if($id > 0 && $id != null){
            $parametros = $this->repositorioDeEntidade->obterParaImprimir($id);
            if($parametros != null){
                $retorno = collect($parametros->toArray());
                $retorno['id'] = $this->stringZero($retorno['id']);

                $empresa = $this->sessionProperties->obterEmpresaBasico();
                if($empresa == null)
                    return $this->obterViewErro503();

                $retorno = $retorno->merge(['empresa' => $empresa]);
                $nomeDaView = $this->sessionProperties->isEmpresaFrigorifico() ? $this->relatorioVendaFrigorifico : $this->relatorioVenda;

                return $this->obterViewPDF(view($nomeDaView, $retorno), false);
            }
        }

        return $this->obterViewErro503();
    }

    public function getImprimirvarios(Request $request){
        $id = $request['id'];
        if($id > 0 && $id != null){
            $parametros = $this->repositorioDeEntidade->obterParaImprimirVarios($id);
            if($parametros != null){
                $retorno = collect($parametros->toArray());
                //$retorno['id'] = $this->stringZero($retorno['id']);

                $empresa = $this->sessionProperties->obterEmpresaBasico();
                if($empresa == null)
                    return $this->obterViewErro503();

//                $retorno = $retorno->merge(['empresa' => $empresa]);

                return $this->obterViewPDF(view("relatorio.venda.impressaovendafrigorificovarios", ["romaneios" => $retorno->toArray()]), false);
            }
        }

        return $this->obterViewErro503();
    }

    public function getInserirquantidadequadrado(Request $request){
        $viewModel = $request->all();
        if($viewModel == null)
            return null;

        $item = $this->obterUpdateViewModelItem($this->obterVendaItens(), $viewModel);
        if($item == null)
            $item = VendaSimplesItemViewModel::CAMPOS;

        return $this->obterView("_updatevendaitemquantidade", array_merge($item , [
            'quantidadeQuadrado' => $viewModel['quantidade'] == 1 ? 0 : $viewModel['quantidade'],
            'quantidadeRealQuadrado' => explode(";", $item['quantidadequadradotexto'])
        ]));
    }

    private function stringZero($string){
        $quantidade = strlen($string);
        return str_pad($string, 6 - $quantidade, "0", STR_PAD_LEFT);
    }

    public function getGerarnotafiscal(Request $request){
        $id = $request['id'];
        if($id > 0 && $id != null){
            $servicoNFe = new ServicoDeNotaFiscal($this->sessionProperties);
            $servicoNFe->gerar($id);
            return "Ok";
        }

        return "Error";
    }

    public function getObtervalorunitarioultimopedido(Request $request){
        if($request['idproduto'] != null && $request['idpessoa'] != null)
            return $this->repositorioDeEntidade->obterValorUnitarioUltimoPedido($request);

        return '[]';
    }


    public function eventoDepoisInserirAlterar($model, $acao, $viewModel){
        if($viewModel['faturar']){
            $model->alterarSituacaoParaVendaConcluida();
            $servicoDeFinanceiroContaReceber = new ServicoDeFinanceiroContaReceber();
            $servicoDeFinanceiroContaReceber->gerarContaReceber($model);
            $model->save();
        }
    }

    protected function obterFiltros(){
        return [
                VendaConstans::codigo => "Código (Data venda)",
                VendaConstans::observacao => "Observação (Data venda)",
                VendaConstans::cliente => "Cliente (Data venda)",
                VendaConstans::transporte => "Transportadora (Descrição/Data venda)",
                // VendaConstans::codigoVencimento => "Código (Data vencimento)",
                // VendaConstans::observacaoVencimento => "Observação (Data vencimento)",
                // VendaConstans::clienteVencimento => "Cliente (Data vencimento)",
            ];
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();

        switch ($request->obterIdFiltro()) {
            case VendaConstans::codigo:
                if($parametro > 0)
                    $request->pAnd('venda.id', $parametro)->pBetweenAnd("datavenda");
                else
                    $request->pBetweenAnd("datavenda");
                break;
            case VendaConstans::observacao:
                $request->pAndLike('venda.observacao', $parametro)->pBetweenAnd("datavenda");
                break;
            case VendaConstans::cliente:
                $request->pBetweenAnd("datavenda")->pAndLike('pessoa.razaosocial', $parametro)->pOrLike('pessoa.codigopesonalizado', $parametro);
                break;
            case VendaConstans::transporte:
                $request->pBetweenAnd("datavenda")->pAndLike('transportadora.descricao', $parametro);
                break;
            default:
                break;
        }
        return $this->getObtergrid($request->obterId(), $request);
    }
}