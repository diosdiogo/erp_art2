<?php

namespace App\Http\Controllers\Behavior;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Validator;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Sistema\Parametro\Financeiro\ParametroFinanceiro;
use App\Enums\Sessao\SessaoControllerEnum;
use Session;
use Redirect;
use App\Helper\Controller\HelperDeControllerGridUpdateBase;
use App\Extension\MapperExtension;
use App\Enums\Controller\ControllerEnum;
use App\Helper\Controller\HelperDropDownList;
use App\Helper\Sessao\HelperDeSessao;
use App\Models\Sistema\Empresa\Empresa;
use App\Helper\Controller\HelperDeControllerBase;

class UpdateBaseController extends BaseController
{
    protected $inserir = true;
    protected $updateViewModel;
    protected $parametro = false;

    public function __construct($folder)
    {
        parent::__construct($folder);
        $updateViewModel = $this->obterUpdateViewModel();
        $this->updateViewModel = new $updateViewModel();

        $repositorio = HelperDeControllerGridUpdateBase::obterRepositorio($this->folder, $this->obterNomeModel());

        if(class_exists($repositorio))
            $this->repositorioDeEntidade = new $repositorio;
    }

    public function getIndex(){
        $this->rotaAdicional = ControllerEnum::InserirMaiusculo;
        return $this->obterGetInserir($this->obterParametrosInserir());
    }

    private function carregarSessao($chaveEmpresa){
        if(!Session::has($chaveEmpresa))
            Session::put($chaveEmpresa, Empresa::where('id', '1')->get());
    }

    protected function obterParametrosPadroes (){
        $chaveEmpresa = HelperDeSessao::chaveUnica(SessaoControllerEnum::Empresa);

        $this->carregarSessao($chaveEmpresa);

        return array(
            'rotaAcao' => strtolower($this->obterNomeModel()),
            'inserir' => $this->inserir,
            'empresas' => Session::get($chaveEmpresa),
            'visualizar' => false
        );
    }

    protected function obterUpdateViewModel(){
        return HelperDeControllerGridUpdateBase::obterUpdateViewModel($this->formatarCaminhoPasta(), $this->obterNomeModel());
    }

    public function postInserir(Request $request){
        $viewModel = $request->all(); 

        $this->mapperViewModelParaUpdateViewModel($viewModel);

        $model = new $this->model($viewModel);
        if(method_exists($model, ControllerEnum::InserirValidarInserir)){
            $validador = Validator::make($viewModel, $model->validarInserir());

            HelperDeControllerGridUpdateBase::ValidarAlias($validador, $model);

            if ($validador->fails()) {
                Session::put(SessaoControllerEnum::NaoLimparUpdateViewModel, true);
                return redirect("$this->rotaAcao/" . ControllerEnum::InserirMinusculo)
                    ->withErrors($validador)
                    ->withInput();
            }
        }

        $model = $model->create($viewModel);
        return redirect(strtolower($this->rotaAcao) . '/concluiredicao/' . $model->id);
    }

    protected function obterGetInserir($arrayAdicional = array()){
        if(Session::has(SessaoControllerEnum::NaoLimparUpdateViewModel) && !Session::get(SessaoControllerEnum::NaoLimparUpdateViewModel)){
            $retorno = $this->obterParametrosPadroes($this->obterRota());
            
            if($arrayAdicional != null && count($arrayAdicional) > 0)
                $retorno = MapperExtension::mapear($retorno, $arrayAdicional);

            if(method_exists($this->updateViewModel, ControllerEnum::InserirMinusculo))
                $retorno = MapperExtension::mapear($retorno, $this->updateViewModel->inserir());

            $retorno = MapperExtension::mapear($retorno, $this->obterParametrosBasicos());
            $retorno = MapperExtension::mapear($retorno, array('acao' => ControllerEnum::InserirMinusculo));
            $retorno =  MapperExtension::mapear($retorno, HelperDeControllerBase::obterParametroPadraoBase(""));

            Session::put(SessaoControllerEnum::UpdateViewModel, $retorno);
        }

        Session::put(SessaoControllerEnum::NaoLimparUpdateViewModel, false);

        return View($this->obterViewUpdate(), $this->updateViewModel());
    }

    public function updateViewModel(){
        if(Session::has(SessaoControllerEnum::UpdateViewModel))
            return Session::get(SessaoControllerEnum::UpdateViewModel);
        else
            new $this->updateViewModel();
    }

    public function mapperViewModelParaUpdateViewModel($viewModel = array()){
        $mapper = MapperExtension::mapear($this->updateViewModel(), $viewModel);
        Session::put(SessaoControllerEnum::UpdateViewModel, $mapper);
    }

    protected function obterParametrosInserir(){
        return null;
    }

    protected function obterViewUpdate(){
        return HelperDeControllerGridUpdateBase::obterViewUpdate($this->obterNomeModel(), $this->folder);
    }

    protected function obterDropDownList($model, $parametro){
        return HelperDropDownList::obter($model, $parametro);
    }

    protected function obterView($view){
        return  view(strtolower($this->pasta .'\\'. $view));
    }
}