<?php

namespace App\Servico\Aplicacao;
use App\Enums\Controller\ControllerEnum;
use Session;

class BaseApplicationService
{
    protected $model;
    protected $repositorioDeEntidade;

    function __construct($_model, $_repositorioDeEntidade) {
        $this->model = new $_model;
        $this->repositorioDeEntidade = new $_repositorioDeEntidade;
    }

    public function Inserir(Request $request){
        $viewModel = $request->all(); 
        
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

    public function Alterar(){
        
    }
}