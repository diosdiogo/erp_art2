<?php

namespace App\Http\Controllers\Behavior;

use DB;
use Session;
use Redirect;
use Validator;
use Exception;
use App\Http\Requests;
use App\Enums\AcaoEnum;
use Illuminate\Http\Request;
use App\Extension\MapperExtension;
use App\Http\Controllers\Controller;
use App\Helper\Sessao\HelperDeSessao;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Controller\ControllerEnum;
use App\Enums\Sessao\SessaoControllerEnum;
use App\Helper\Controller\HelperDropDownList;
use App\Helper\Controller\HelperDeControllerGridUpdateBase;
use \App\Models\Sistema\Parametro\Financeiro\ParametroFinanceiro;

class GridUpdateBaseController extends GridBaseController
{
    protected $inserir = true;
    protected $updateViewModel;
    protected $minimizarMenu = 1;
    protected $parametro = false;
    protected $nomeUpdateViewModel;
    protected $rotaAcaoErro;
    protected $id;

    public function __construct($folder)
    {
        parent::__construct($folder);

        if($this->usuarioAutenticado){
            $this->sessionProperties != null?  $this->sessionProperties : $this->sessionProperties = new SessionProperties();
            $updateViewModel = $this->obterUpdateViewModel();
            $this->updateViewModel = new $updateViewModel();
            $this->rotaAcaoRetornarErro();
        }
    }

    public function getIndex(){
        return $this->obterViewAutenticada(function(){
                $retorno = MapperExtension::mapear($this->obterParametrosPadroes(), $this->obterParametrosPadroesBase());
                $retorno = MapperExtension::mapear($retorno, $this->obterParametrosIndex());
                return view($this->obterViewGrid(), $retorno);
        });
    }


    protected function obterParametrosIndex(){
        return array();
    }

    protected function obterUpdateViewModel(){
        return HelperDeControllerGridUpdateBase::obterUpdateViewModel($this->formatarCaminhoPasta(), $this->obterNomeModel());
    }

    protected function obterGetInserir($arrayAdicional = array()){
        $chaveEmpresa = HelperDeSessao::chaveUnica(SessaoControllerEnum::Empresa);

        if(Session::has(SessaoControllerEnum::NaoLimparUpdateViewModel) && !Session::get(SessaoControllerEnum::NaoLimparUpdateViewModel)){
            $retorno = $this->obterParametroRota();

            if(method_exists($this->updateViewModel, ControllerEnum::InserirMinusculo))
                $retorno = MapperExtension::mapear($retorno, $this->updateViewModel->inserir());

            if($arrayAdicional != null && count($arrayAdicional) > 0)
                $retorno = MapperExtension::mapear($retorno, $arrayAdicional);

            $retorno = MapperExtension::mapear($retorno, $this->obterParametrosBasicos());
            $retorno = MapperExtension::mapear($retorno, $this->obterAction());
            $retorno = MapperExtension::mapear($retorno, $this->obterParametrosManuais());

            $retorno = MapperExtension::mapear($retorno,
                    array(
                          'idempresa' => '1',
                          'acao' => ControllerEnum::InserirMinusculo,
                          'empresas' => Session::get($chaveEmpresa),
                          'dataInicial' => $this->dataInicial)
                    );

           Session::put(SessaoControllerEnum::UpdateViewModel, collect($retorno));
        }

        Session::put(SessaoControllerEnum::NaoLimparUpdateViewModel, false);

        return View($this->obterViewUpdate(), $this->updateViewModel()->all());
    }

    protected function obterParametrosManuais(){
        return array();
    }

    public function getInserir(){
        return $this->obterViewAutenticada(function(){
                $this->rotaAdicional = ControllerEnum::InserirMaiusculo;
                return $this->obterGetInserir($this->obterParametrosInserir());
            });
    }

    public function postInserir(Request $request){
        $viewModel = $request->all();
        $this->acertarEntidade($viewModel);
        $this->preencherViewModel($viewModel);
        $this->mapperViewModelParaUpdateViewModel($viewModel);
        $model = new $this->model($viewModel);
        if(method_exists($model, ControllerEnum::InserirValidarInserir)){
            $validador = Validator::make($this->updateViewModel()->all(), $model->validarInserir(), $model->mensagemAlias);
            HelperDeControllerGridUpdateBase::ValidarAlias($validador, $model);

            if ($validador->fails()) {
                Session::put(SessaoControllerEnum::NaoLimparUpdateViewModel, true);
                return redirect("$this->rotaAcaoErro/" . ControllerEnum::InserirMinusculo)->withErrors($validador)->withInput();
            }
        }
        try {
            $model = $model->inserir($this->updateViewModel()->all());
            $this->corrigirRelacionamentoInserir($model);
            $this->eventoDepoisInserir($model);
            $this->eventoDepoisInserirAlterar($model, AcaoEnum::INSERIR, $viewModel);
        }catch(Exception $e){
            dd($e);
            dd($e->errorInfo[2]);
        }

        Session::flash("idModeloInserido", $model->id);
        return $this->concluirEdicacao($model->id);
    }

    protected function obterGetAlterar($id = 0, $alterar = true){
        $retorno = $this->obterParametrosPadroes($this->obterRota());
        $model = $this->model;

        if(method_exists($this->updateViewModel, ControllerEnum::InserirMinusculo))
            $retorno = MapperExtension::mapear($retorno, $this->updateViewModel->inserir());

        $modelo = $this->obterModelParaAlterar($id);

        if($modelo == null)
            return view("errors.503");

        $this->preencherViewModel($modelo);

        if($alterar){
            $validador =  HelperDeControllerGridUpdateBase::ValidarAntesDeAlterar($model, $modelo);

            if ($validador->fails())
                return redirect("$this->rotaAcaoErro/concluiredicao/$id")
                    ->withErrors($validador)
                    ->withInput();
        }

        if(is_array($modelo))
            $retorno = MapperExtension::mapear($retorno, $modelo);
        else
            $retorno = MapperExtension::mapear($retorno, $modelo->toArray());

        $retorno = MapperExtension::mapear($retorno, $this->obterParametrosBasicos());
        $retorno = MapperExtension::mapear($retorno, array('acao' => "alterar/$id", 'idempresa' => '1'));
        $retorno = MapperExtension::mapear($retorno, $this->obterAction(false));
        $retorno = MapperExtension::mapear($retorno, $this->obterParametrosManuais());

        Session::put(SessaoControllerEnum::UpdateViewModel, collect($retorno));
        Session::put(SessaoControllerEnum::NaoLimparUpdateViewModel, false);
        $this->obterParametroAlterar();

        return View($this->obterViewUpdate(), $this->updateViewModel()->all());
    }

    public function getAlterar($id = 0){
        $this->id = $id;
        return $this->obterViewAutenticada(function(){
            if(isset($this->id) && $this->id > 0){
                $this->rotaAdicional = ControllerEnum::AlterarMinusculo;
                return $this->obterGetAlterar($this->id);
            }else
                return $this->obterViewErro503();
        });
    }

    public function postAlterar(Request $request, $id){
        $viewModel = $request->all();
        $model = new $this->model();
        $this->acertarEntidade($viewModel);
        $this->mapperViewModelParaUpdateViewModel($viewModel);

        if(method_exists($model, ControllerEnum::AlterarValidarAlterar)){
            $validator = Validator::make($this->updateViewModel()->all(), $model->validarAlterar($id), $model->mensagemAlias);

            HelperDeControllerGridUpdateBase::ValidarAlias($validator, $model);

            if ($validator->fails())
                return redirect("$this->rotaAcaoErro/alterar/$id")->withErrors($validator)->withInput();
        }

        $entidade = $model::find($id);
        $model->alterar($entidade, $viewModel);

        $this->corrigirRelacionamentoAlterar($entidade);

        $this->eventoDepoisAlterar($entidade);
        $this->eventoDepoisInserirAlterar($entidade, AcaoEnum::ALTERAR, $viewModel);

        return $this->concluirEdicacao($id);
    }

    public function validarEntidadeGrid($model, $metodo){
        $validador = Validator::make($model->toArray(), $metodo);

        HelperDeControllerGridUpdateBase::ValidarAlias($validador, $model);

        if ($validador->fails())
            return array("erro" => true, "retorno" =>redirect("$this->rotaAcaoErro/concluiredicao/" . $model->id)->withErrors($validador)->withInput());

        return $this->concluirEdicacao($model->id);
    }

    protected function concluirEdicacao($id){
        return redirect(strtolower($this->rotaAcao) . '/concluiredicao/' . $id);
    }

    protected function obterParametroRota(){
        return array('rotaAcao' => $this->rotaAcao);
    }

    public function updateViewModel(){
        if($this->updateViewModel == null)
            return null;

        if(Session::has(SessaoControllerEnum::UpdateViewModel))
            return Session::get(SessaoControllerEnum::UpdateViewModel);
        else
            return collect($this->updateViewModel->inserir());
    }

    public function adicionar($propriedade, $viewModel = array()){
        $novoArray = collect($this->updateViewModel()->get($propriedade));
        $novoArray->push($viewModel);
        $this->updateViewModel()->put($propriedade, $novoArray);
        Session::put(SessaoControllerEnum::UpdateViewModel, collect($this->updateViewModel()->all()));
    }

    public function remover($propriedade, $id, $campo = 'id'){
        $novoArray = collect($this->updateViewModel()->get($propriedade))
        ->reject(function ($item) use(&$id, &$campo) {
            return $item[$campo] == $id;
        });

        $this->updateViewModel()[$propriedade] = $novoArray;
        Session::put(SessaoControllerEnum::UpdateViewModel, collect($this->updateViewModel()->all()));
    }

    public function removerTodos($propriedade){
        $this->updateViewModel()[$propriedade] = array();
        Session::put(SessaoControllerEnum::UpdateViewModel, collect($this->updateViewModel()->all()));
    }

    protected function obterParametrosInserir(){
        return null;
    }

    protected function obterViewUpdate(){
        $view = $this->nomeUpdateViewModel != "" ?  $this->nomeUpdateViewModel : $this->obterNomeModel();
        return HelperDeControllerGridUpdateBase::obterViewUpdate($view, $this->folder);
    }

    protected function obterView($view, $parametro = array()){
        return view(strtolower(str_replace("\\", "/", $this->pasta) .'/'. $view), $parametro);
    }

    public function obterUpdateViewModelItem($lista, $viewModel){
        $item = collect($lista)->filter(function ($value, $key) use (&$viewModel) {
            return $value['id'] == $viewModel['id'];
        })->first();

        return $item;
    }

    public function getVisualizar($id){
        if($id > 0){
            $this->rotaAdicional = "Visualizar";
            return $this->obterGetAlterar($id, false);
        }
    }

    protected function obterDropDownList($model, $parametro){
        return HelperDropDownList::obter($model, $parametro);
    }

    protected function obterDropDownListDinamico($model, $parametro, $campo, $campoDescricao = 'descricao'){
        return HelperDropDownList::obterDinamico($model, $parametro, $campo, $campoDescricao);
    }

    protected function obterDropDownListBase($model, $parametro){
        return HelperDropDownList::obterBase($model, $parametro);
    }

    protected function obterBasicoWhere($model, $request, $where, $campoDescricao = 'descricao'){
        return HelperDropDownList::obterBasicoWhere($model, $request, $where, $campoDescricao);
    }

    protected function obterDinamicoWhere($model, $request, $campos, $where){
        return HelperDropDownList::obterDinamicoWhere($model, $request, $campos, $where);
    }

    private function corrigirRelacionamentoAlterar($model){
        if($this->repositorioDeEntidade && method_exists($this->repositorioDeEntidade, ControllerEnum::AlterarMetodoCorrigirRelacionamento))
            $this->repositorioDeEntidade->corrigirRelacionamentoAlterar($model, $this->updateViewModel());
    }

    private function corrigirRelacionamentoInserir($model){
        if($this->repositorioDeEntidade && method_exists($this->repositorioDeEntidade, ControllerEnum::InserirMetodoCorrigirRelacionamento))
            $this->repositorioDeEntidade->corrigirRelacionamentoInserir($model, $this->updateViewModel());
    }


	private function obterAction($inserir = true){
        return array('action' => $inserir ? ControllerEnum::InserirMinusculo : ControllerEnum::AlterarMinusculo);
    }

    private function obterModelParaAlterar($id){
        if($this->repositorioDeEntidade)
            return $this->repositorioDeEntidade->obterParaAlterar($id);

        return $this->obterModelEspecifico()->where('id', '=', $id)->first();
    }

	private function mapperViewModelParaUpdateViewModel($viewModel = array()){
        $mapper = $this->updateViewModel()->merge($viewModel);
        Session::put(SessaoControllerEnum::UpdateViewModel, collect($mapper));
    }

	private function rotaAcaoRetornarErro(){
        $this->rotaAcaoErro = $this->rotaAcaoErro != "" ? $this->rotaAcaoErro : $this->rotaAcao;
    }

    protected function eventoDepoisInserirAlterar($model, $acao, $viewModel){}

    protected function eventoDepoisInserir($model){}

    protected function eventoDepoisAlterar($model){}

    protected function obterParametroAlterar(){ return array(); }

    protected function acertarEntidade(&$viewModel){}

    protected function preencherViewModel(&$viewModel){}
}