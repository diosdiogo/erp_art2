<?php

namespace App\Http\Controllers\Behavior;

use DB;
use App;
use Session;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Extension\MapperExtension;
use App\Http\Controllers\Controller;
use App\Helper\Sessao\HelperDeSessao;
use App\Enums\Controller\ControllerEnum;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Empresa\Empresa;
use App\Enums\Sessao\SessaoControllerEnum;
use App\Helper\Controller\HelperDeControllerBase;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Helper\Controller\HelperDeControllerGridUpdateBase;
use App\Http\Controllers\Behavior\Contrato\IGridBaseController;

class GridBaseController extends BaseAuthController implements IGridBaseController
{
    protected $gridViewModel;
    protected $inserir = false;
    protected $registrosObter = null;
    protected $repositorioDeEntidade;
    protected $obterPorEmpresa = false;
    protected $obterPorEmpresaEUsuario = false;
    protected $gridView;
    protected $minimizarMenu = 0;
    protected $dataInicial;
    protected $dataFinal;

    public function __construct($folder)
    {
        parent::__construct($folder);
        if($this->usuarioAutenticado)
            $this->inicializarRepositorio();
    }

    private function inicializarRepositorio(){
        $repositorio = HelperDeControllerGridUpdateBase::obterRepositorio(ucfirst($this->folder), $this->obterNomeModel());
        if(class_exists($repositorio))
            $this->repositorioDeEntidade = new $repositorio;
    }

    private function carregarSessao($chaveEmpresa){
        if(!Session::has($chaveEmpresa))
            Session::put($chaveEmpresa, Empresa::where('id', '1')->get());

        $this->dataInicial = HelperDeSessao::has(SessaoControllerEnum::DataInicial) ? HelperDeSessao::get(SessaoControllerEnum::DataInicial) : date('Y-m-d');
        $this->dataFinal = HelperDeSessao::has(SessaoControllerEnum::DataFinal) ? HelperDeSessao::get(SessaoControllerEnum::DataFinal) : date('Y-m-d');
    }

    protected function obterModelEspecifico(){
        $model = null;
        if($this->obterPorEmpresa)
            $model = $this->model->where('idempresa', '=', '1');
        else if($this->obterPorEmpresaEUsuario)
            $model = $this->model->where('idempresa', '=', '1')->where('idusuario', '=', HelperDeSessao::obterIdUsuario());
        else
            $model = $this->model;
        return $model;
    }

    private function obterGridInterno(){
        $this->registrosObter = $this->obterModelEspecifico()->get();
    }

    protected function obterChaveUnica(){
        return HelperDeSessao::chaveUnica(SessaoControllerEnum::Empresa);
    }

    protected function obterParametrosPadroes (){
        $chaveEmpresa = $this->obterChaveUnica();
        $this->carregarSessao($chaveEmpresa);
        $this->obterGridInterno();
        return array(
            'dataInicial' => $this->dataInicial,
            'dataFinal' => $this->dataFinal,
            'grid' => $this->obterParametroGridManual(),
            'rotaAcao' => $this->rotaAcao,
            'campos' => $this->obterCamposGrid(),
            'inserir' => $this->inserir,
            'empresas' => Session::get($chaveEmpresa),
            'filtros' => $this->obterFiltros(),
            'visualizar' => false,
            'minimizarMenu' => $this->minimizarMenu
        );
    }

    protected function obterParametroGridManual(){
        return array();
    }

    private function obterParametrosGridBase(){
        return MapperExtension::mapear($this->obterParametrosPadroes(), $this->obterParametrosPadroesBase());
    }

    public function getIndex(){
        Session::put(SessaoControllerEnum::NaoLimparUpdateViewModel, false);
        return view($this->obterViewGrid(), $this->obterParametrosGridBase());
    }

    public function getConcluiredicao($id = ''){
        Session::flash(SessaoControllerEnum::ConcluirEdicao, $id);
        return view($this->obterViewGrid(), MapperExtension::mapear($this->obterParametrosGridBase(), array("id" => $id)));
    }

    protected function obterGridViewModel(){
        $pasta = $this->formatarCaminhoPasta();
        $model = $this->obterNomeModel();
        return "App\\ViewModel\\Sistema\\$pasta\\Grid$model". "ViewModel";
    }

    protected function obterCamposGrid(){
        return null;
    }

    protected function obterParametrosBasicos(){
        return MapperExtension::mapear(array('nomeController' => $this->obterNomeController()), $this->obterParametrosPadroesBase());
    }

    protected function obterViewGrid(){
        $model = $this->obterNomeModel();
        $pasta = str_replace("\\", ".",$this->folder);
        $nomeView = $this->gridView ? $this->gridView : $model;
        return strtolower("$pasta.grid$nomeView");
    }

    protected function obterFiltros(){
        return array("1" => "Codigo", "2" => "Descricao");
    }

    public function getObtergrid($id = "", ParametrosGrid $request){
        $id = $this->obterIdConcluirEdicao($id);
        
        if($this->repositorioDeEntidade && method_exists($this->repositorioDeEntidade, ControllerEnum::ObterGrid))
            return $this->repositorioDeEntidade->obterGrid($request);

        if($id != "")
            return $this->model->where('id', '=', $id)->get();

        $this->obterGridInterno();
        return $this->registrosObter;
    }

    private function obterIdConcluirEdicao($id = 0){
        if($id == 0 || $id == ''){
            if(Session::has(SessaoControllerEnum::ConcluirEdicao))
                if(Session::get(SessaoControllerEnum::ConcluirEdicao) > 0)
                    $id = Session::get(SessaoControllerEnum::ConcluirEdicao);
        }

        return $id;
    }

    public function GridViewModel(){
        if(Session::has(SessaoControllerEnum::GridViewModel))
            Session::get(SessaoControllerEnum::GridViewModel);
    }

    protected function obterViewPDF($view, $html = false){
        if($html)
            return $view;

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();
    }

    public function getExcluir($id){
        if($id > 0){
            $model = $this->model;
            $registro = new $model();
            if($model != null){
                $validador =  HelperDeControllerGridUpdateBase::ValidarAntesDeDeletar($model, $registro::where('id', '=', $id)->get()[0]);

                if ($validador->fails())
                    return redirect("$this->rotaAcaoErro/concluiredicao/$id")
                        ->withErrors($validador)
                        ->withInput();

                $model::destroy($id);
            }
        }
    }

    public function obterErrorParaGridTemplate($id, $erros){
        return redirect("$this->rotaAcaoErro/concluiredicao/$id")->withErrors($erros)->withInput();
    }

    protected function retorno($retorno, $condicaoErro = true){
        return [$condicaoErro ? 'error' : '' => $retorno];
    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        return $this->getObtergrid($request->obterId(), $request);
    }
}