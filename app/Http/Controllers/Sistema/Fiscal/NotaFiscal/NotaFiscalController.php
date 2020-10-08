<?php
namespace App\Http\Controllers\Sistema\Fiscal\NotaFiscal;

use DB;
use Session;
use App\Helper\SessionProperties;
use Illuminate\Http\Request;
use App\Extension\CommonExtension;
use App\Models\Sistema\Venda\Venda;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Enums\NotaFiscalSituacaoEnum;
use App\Models\Sistema\Produto\Produto;
use App\Servico\Sistema\Venda\ServicoDeVenda;
use App\Helper\Controller\HelperDropDownList;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Servico\Sistema\Fiscal\ServicoDeNotaFiscalNova;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscal;
use App\Repositorio\Sistema\Pessoa\RepositorioDePessoa;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Models\Sistema\Fiscal\NaturezaOperacao\FiscalNaturezaOperacao;
use App\ViewModel\Sistema\Fiscal\NotaFiscal\UpdateNotaFiscalItemViewModel;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItem;
use App\Models\Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipo;
use App\Servico\Sistema\Financeiro\FormaRecebimento\ServicoDeFinanceiroFormaRecebimento;
use App\Models\Sistema\Fiscal\CST\FiscalCSTICMS;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;
use App\Extension\MapperExtension;

class NotaFiscalController extends GridUpdateBaseController
{
    protected $pasta = "fiscal\\NotaFiscal";
    protected $servicoDeNotaFiscal;
    protected $repositorioDePessoa;
    protected $notaFiscalItem = "notafiscalitens";
    protected $parcelaitens = "parcelaitens";
    protected $empresa = "empresas";
    protected $servicoDeFinanceiroFormaRecebimento;
    protected $servicoDeVenda;
    protected $parametroInserir;
    protected $mensagemErro = "";
    protected $inserir = false;

    public function __construct(Request $request)
    {
        parent::__construct($this->pasta);
        $this->servicoDeFinanceiroFormaRecebimento = new ServicoDeFinanceiroFormaRecebimento($this);
        $this->servicoDeVenda = new ServicoDeVenda($this->updateViewModel());
        $this->repositorioDePessoa = new RepositorioDePessoa();
        $this->parametroInserir = $request->all();
        
        try
        {
           $this->servicoDeNotaFiscal = new ServicoDeNotaFiscalNova($this->sessionProperties);
        }
        catch (\Exception $exception)
        {
           $this->mensagemErro = $this->retorno('[CERTIFICADO] ' . $exception->getMessage() . ', não é possivel fazer qualquer ação até resolver o problema');
        }
    }

    protected function obterParametrosIndex(){
        return $this->mensagemErro;
    }

    protected function obterParametrosManuais(){

        return [
            'isEmpresaFrigorifico' => $this->sessionProperties->isEmpresaFrigorifico(),
            'isEmpresaMateriasConstrucao' => $this->sessionProperties->isEmpresaMateriasConstrucao(),
            'origemvenda' => $this->obterOrigemVenda()
        ];
    }

    private function obterOrigemVenda(){
        if(isset($this->updateViewModel()['numerodocumentoorigem'])){
            return Venda::where('id', $this->updateViewModel()['numerodocumentoorigem'])->exists();
        }
        return false;
    }

    protected function obterParametrosInserir(){
        if($this->parametroInserir != null){
            if($this->parametroInserir['origem'] > 0 && $this->parametroInserir['id'] > 0)
                return $this->servicoDeVenda->gerarNotaFiscal($this->parametroInserir['id']);
        }

        return null;
    }

    public function getValidarnotafiscalorigemvenda(Request $request){
        $id = $request['id'];
        if($id > 0){
            $venda = Venda::where('id', $id)->first();
            $notaFiscal = NotaFiscal::where('numerodocumentoorigem', $id)->orderBy('id', 'desc')->first();
            if(!$notaFiscal == null){
                $naoGerarNotaFiscal = (!$venda->isSituacaoConcluida() || (!$notaFiscal->isSituacaoCancelada()));

                if($naoGerarNotaFiscal)
                    return $this->retorno("Só é permitido gerar nota fiscal, caso a situação da venda esteja [CONCLUÍDO] e não existir NFe com
                    a situação [AUTORIZADA]");
            }else{
                if(!$venda->isSituacaoConcluida()){
                    return $this->retorno("Só é permitido gerar nota fiscal, caso a situação da venda esteja [CONCLUÍDO] e não existir NFe com
                    a situação [AUTORIZADA]");
                }
            }
        }else{
            return $this->retorno("É necessário selecionar um pedido antes de criar uma nota do tipo [VENDA]");
        }

    }

    /* NOTA FISCAL PROPRIO */
    public function getConsultarstatussefaz(Request $request){
        $idEmpresa = $request['idEmpresa'];
        if($this->mensagemErro == "")
            return $this->servicoDeNotaFiscal->consultarStatusServicoSEFAZ($idEmpresa);
        return $this->mensagemErro;
    }

    public function getObternaturezaoperacao(Request $request){
        return $this->obterDropDownList(FiscalNaturezaOperacao::class, $request);
    }

    public function getObterpessoa(Request $request){
        return $this->obterDropDownListDinamico(Pessoa::class, $request, "id", "razaosocial");
    }

    public function getVisualizardanfe(Request $request){
        return $this->servicoDeNotaFiscal->gerarDANFE($request['id'], $this->updateViewModel());
    }

    public function getBaixardanfe(Request $request){
        return $this->servicoDeNotaFiscal->downloadDANFE($request['id']);
    }

    public function getObterpessoaendereco(Request $request){
        $id = $request['id'];
        return $this->repositorioDePessoa->obterEndereco($id);
    }

    public function getEnviarnotafiscal(Request $request){
        $id = $request['id'];
        $notaFiscal = $this->model->where('id', $id)->first();

        if($notaFiscal->idnotafiscalsituacao == NotaFiscalSituacaoEnum::ENVIAR || $notaFiscal->idnotafiscalsituacao == NotaFiscalSituacaoEnum::REJEICAO){
            $retorno = $this->servicoDeNotaFiscal->gerarNotaFiscal($notaFiscal);

            Session::flash("idFlash", $id);

            if(is_array($retorno) && (array_key_exists('erro', $retorno) || array_key_exists('error', $retorno)))
                return $retorno;

            if($notaFiscal->idnotafiscalsituacao)
                return $this->retorno($notaFiscal->motivoretorno, !$notaFiscal->isSituacaoAutorizada());
        }
        else
            return $this->retorno("NF-e deve estar na situação ABERTA ou REJEIÇÃO para enviar");
    }

    public function getCancelar(Request $request){
        $id = $request['id'];
        $notaFiscal = $this->model->where('id', $id)->first();

        if($notaFiscal->idnotafiscalsituacao == NotaFiscalSituacaoEnum::AUTORIZADA){
            $this->servicoDeNotaFiscal->cancelar($notaFiscal);
            // if($notaFiscal->idnotafiscalsituacao)
            //     return $this->retorno($notaFiscal->motivoretorno, !$notaFiscal->isSituacaoAutorizada());
        }
        else
            return $this->retorno("NF-e deve estar na situação AUTORIZADA cancelar");
    }

    public function getInutilizar(Request $request){
        $viewModel = $request->all();
        $retorno = $this->servicoDeNotaFiscal->inutilizar((object)$viewModel);
        return [$retorno->cStat =>  $retorno->xMotivo];
    }

    /* FIM */

    private function obterNotaFiscalItens(){
        return $this->updateViewModel()->get($this->notaFiscalItem);
    }

    public function getObteritens(){
        return collect($this->obterNotaFiscalItens())->values()->toArray();
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
        //$this->servicoDeVenda->validarValorRecebido($viewModel);
        $viewModel['idnotafiscalsituacao'] = ($viewModel['idnotafiscalsituacao'] == "" ? NotaFiscalSituacaoEnum::ENVIAR : $viewModel['idnotafiscalsituacao']);
        $viewModel['valortotal'] = CommonExtension::removerVirgulaPorPonto($this->getObtervalortotal());
    }

    public function getObterproduto(Request $request){
        return HelperDropDownList::obterProdutoNotaFiscal(Produto::class, $request);
    }

    public function getObterespecie(Request $request){
        return HelperDropDownList::obter(FinanceiroFormaRecebimentoTipo::class, $request);
    }

    public function getInserirnotafiscalitem(){
        $viewModel = $this->obterNotaFiscalItemViewModel();
        return $this->obterView("_updatenotafiscalitem", $viewModel, $this->obterParametrosManuais());
    }

    private function obterNotaFiscalItemViewModel(){
        return MapperExtension::mapear(UpdateNotaFiscalItemViewModel::campos(), ['origemvenda' => isset($this->updateViewModel()['origemvenda']) ? $this->updateViewModel()['origemvenda'] : false]);
    }

    public function postInserirnotafiscalitem(Request $request){
        $viewModel = $request->all();
        $id = collect($this->obterNotaFiscalItens())->max('id') + 1;
        $viewModel['id'] = $id;
        $viewModel['item'] = $id;
        $idProduto = $viewModel['idproduto'];
        if($idProduto > 0){
            $produto = $this->obterProduto($idProduto);
            
            $viewModel['idunidademedida'] = $produto->idunidademedida;
            $unidadeMedida = $produto->UnidadeMedida;
            $viewModel['unidademedidacomercial'] = $unidadeMedida->descricao;
        }
        

        $viewModel['idcst'] = "";
        $viewModel['acrescimomoeda'] = 0;
        $viewModel['descontomoeda'] = 0;
        $viewModel['descontoporcentagem'] = 0;
        $viewModel['valordesconto'] = 0;
        $viewModel['valorunitario'] = $this->sessionProperties->isEmpresaFrigorifico() ? CommonExtension::formatarTextoParaDecimal($viewModel['valorunitario']) : $this->obterValorProduto($idProduto);
        $viewModel['valortotal'] = $this->calcularValorTotalNotaFiscalItem($viewModel);
        $this->adicionar($this->notaFiscalItem, $viewModel);
        return $viewModel;
    }

    private function calcularValorTotalNotaFiscalItem($viewModel){
        $valorTotal = $viewModel['quantidade'] * ($viewModel['acrescimomoeda'] - $viewModel['descontomoeda'] + $this->obterValorUnitarioItemPorcentagem($viewModel));
        return $valorTotal > 0 ? str_replace(",", ".", $valorTotal) : 0;
    }

    private function obterProduto($id){
        return Produto::where('id', $id)->first();
    }

    private function obterValorProduto($id){
        return Produto::select('preco')->where('id', $id)->first()->preco;
    }

    public function getAlterarnotafiscalitem(Request $request){
        $viewModel = $request->all();
        $item = $this->obterUpdateViewModelItem($this->obterNotaFiscalItens(), $viewModel);
        $item = MapperExtension::mapear($this->obterNotaFiscalItemViewModel(), $item);
        $item['valortotal'] = ($item['quantidade'] * $item['valorunitario'] ) * 100;
        $this->preencherCSTICMSeCFOP($item, $item);
        //$item = array_merge($item, array('quantidadeRealQuadrado' => explode(";", $item['quantidadequadradotexto'])));
        return $this->obterView("_updatenotafiscalitem", array_merge($item, $this->obterParametrosManuais()));
    }

    public function postAlterarnotafiscalitem(Request $request){
        $viewModel = $request->all();
        $item = $this->obterUpdateViewModelItem($this->obterNotaFiscalItens(), $viewModel);
        $this->remover($this->notaFiscalItem, $viewModel['id']);
        $this->preencherCSTICMSeCFOP($item, $viewModel);
        $this->adicionar($this->notaFiscalItem, $item);
        return $viewModel;
    }

    private function preencherCSTICMSeCFOP(&$item, &$viewModel){
        $item['idcsticms'] = isset($viewModel['idcsticms']) ? intval($viewModel['idcsticms']): 0;
        if($item['idcsticms'] > 0){
            $fiscalCSTICMS = FiscalCSTICMS::where('id', $item['idcsticms'])->first();
            $item['descricaocsticms'] = CommonExtension::adicionarCodigoEDescricao($fiscalCSTICMS, "codigo");
            $item['CST'] = $fiscalCSTICMS['codigo'];
        }else{
            $item['descricaocsticms'] = "";
            $item['CST'] = "";
        }

        $item['idcfop'] = isset($viewModel['idcfop']) ? intval($viewModel['idcfop']): 0;
        if($item['idcfop'] > 0){
            $fiscalCFOP = FiscalCFOP::where('id', $item['idcfop'])->first();
            $item['idcfop'] = $item['CFOP'] = intval($viewModel['idcfop']);
            $item['descricaocfop'] = CommonExtension::adicionarCodigoEDescricao($fiscalCFOP);
        }else{
            $item['CFOP'] = "";
            $item['descricaocfop'] = "";
        }

    }

    public function getObterformarecebimentoitem(Request $request){
        $idformarecebimento = $request['idformarecebimento'];

        if($request != null && $idformarecebimento != null)
            return HelperDropDownList::obterWhere(FinanceiroFormaRecebimentoItem::class, "idformarecebimento = $idformarecebimento");

        return null;
    }

    private function obterValorTotalVenda(){
        return str_replace(",", "." , collect($this->obterNotaFiscalItens())->sum('valortotalitem'));
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
        return 0;//$this->servicoDeFinanceiroFormaRecebimento->calcularDiferencaParcelas($this->obterValorTotalVenda(), $this->obterValorTotalParcelaFormatado())['diferencia'];
    }

    public function getCalcularvalortotalitem(Request $request){
        return $this->calcularValorTotalNotaFiscalItem($request);
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

    public function postDeletarnotafiscalitem(Request $request){
        $viewModel = $request->all();
        $this->remover($this->notaFiscalItem, $viewModel['id']);

        return $viewModel;
    }

    public function getObterdiasemanapessoa(Request $request){
        $id = $request['id'];
        if($id > 0 && $id != null){
            return DB::select(DB::raw(@"SELECT descricao FROM pessoa
                LEFT JOIN diadasemana ON diadasemana.id = pessoa.iddiadasemana
                WHERE pessoa.id = $id"));
        }
    }

    protected function obterFiltros(){
        return [
                0 => "Código",
                // VendaConstans::observacao => "Observação (Data venda)",
                // VendaConstans::cliente => "Cliente (Data venda)",
            ];
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();
        // switch ($request->obterIdFiltro()) {
        //     case 1:
        //     case 0:
        //         if($parametro > 0)
        $request->pAnd('notafiscal.id', $parametro);
        //         dd($request);
        //         break;
        //     default:
        //         break;
        // }
        $request->pOrderByDesc('notafiscal.id');

        return $this->getObtergrid($request->obterId(), $request);
    }

    public function getObtercsticms(Request $request){
        return $this->obterDropDownListDinamico(FiscalCSTICMS::class, $request, "codigo");
    }
}