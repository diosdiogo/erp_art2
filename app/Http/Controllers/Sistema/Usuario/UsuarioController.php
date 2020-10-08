<?php
namespace App\Http\Controllers\Sistema\Usuario;

use Hash;
use Illuminate\Http\Request;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

class UsuarioController extends GridUpdateBaseController
{
    protected $pasta = "usuario";
    protected $obterPorEmpresa = "true";

    public function __construct()
    {
        parent::__construct($this->pasta);
        $this->inserir = $this->isPossivelInserir();
    }

    protected function obterModelEspecifico(){
        $idFilial = $this->sessionProperties->obterIdFilial();
        return $this->model->where('idempresafilial', '=', $idFilial);
    }

    protected function acertarEntidade(&$viewModel){
        $viewModel['password'] = \Hash::make($viewModel['password']);
        $viewModel['imagem'] = "mabi";
        $viewModel['usuarioAtualSupervisor'] = \Auth::user()->supervisor;
        $viewModel['idempresafilial'] = $this->sessionProperties->obterIdFilial();
    }

    protected function preencherViewModel(&$viewModel){
        $viewModel['usuarioAtualSupervisor'] = \Auth::user()->supervisor;
    }

    private function isPossivelInserir(){;
        $quantidadeUsuarioInserida = $this->obterModelEspecifico()->count();
        $quantidadeUsuarioPermitida = $this->sessionProperties->obterEmpresaFilial()->quantidadeusuario;

        return ($quantidadeUsuarioPermitida - $quantidadeUsuarioInserida) > 0 && \Auth::user()->supervisor == 1;
    }
}