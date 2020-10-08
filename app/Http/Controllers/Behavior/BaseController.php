<?php

namespace App\Http\Controllers\Behavior;

use DB;
use App;
use Gate;
use Session;
use Validator;
use App\Http\Requests;
use App\Enums\GateEnum;
use Illuminate\Http\Request;
use App\Helper\SessionProperties;
use App\Http\Controllers\Controller;
use App\Helper\Controller\HelperDeControllerBase;

class BaseController extends Controller
{
    protected $folder;
    protected $nomeController;
    protected $model;
    protected $nomeModel;
    protected $rotaAdicional;
    protected $gridView;
    protected $rotaAcao;
    protected $inicializarModel = true;
    protected $sessionProperties;
    protected $usuarioAutenticado;

    public function __construct($folder)
    {
        $this->usuarioAutenticado = !Gate::denies(GateEnum::USUARIO_LOGADO);
        if ($this->usuarioAutenticado) {
            $this->folder = $folder;
            $this->inicializarModelo();
            $this->nomeController = $this->obterNomeController();
            $this->inicializarRotaAcao();
            $this->sessionProperties = new SessionProperties();
        }
    }

    private function inicializarRotaAcao()
    {
        $rota = $this->rotaAcao != "" ? $this->rotaAcao : strtolower($this->obterNomeModel());
        $this->rotaAcao = strtolower($rota);
    }

    protected function inicializarModelo()
    {
        $pastaEncontrada = strlen($this->folder) > 0;

        if ($pastaEncontrada) {
            $this->nomeModel = $this->obterNomeModel();
            $model = $this->obterModel();

            if ($this->inicializarModel) {
                $this->model = new $model;
            }
        }
    }

    protected function obterViewPDF($view, $html = false)
    {
        if ($html) {
            return $view;
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view);
        return $pdf->stream();
    }
    
    protected function obterParametrosPadroesBase()
    {
        return HelperDeControllerBase::obterParametroPadraoBase($this->obterRota());
    }

    protected function obterParametrosPadraoExtra()
    {
        return array();
    }

    public function getIndex()
    {
        return HelperDeControllerBase::obterRotinaIndex($this->obterRota(), $this->gridView, $this->obterParametrosPadraoExtra());
    }

    protected function formatarCaminhoPasta()
    {
        return HelperDeControllerBase::formatarCaminhoPasta($this->folder);
    }

    protected function obterModel()
    {
        return HelperDeControllerBase::obterModel($this->formatarCaminhoPasta(), $this->obterNomeModel());
    }

    protected function obterNomeModel()
    {
        if ($this->nomeModel != "") {
            return $this->nomeModel;
        }

        return HelperDeControllerBase::obterNomeModel($this->obterNomeController());
    }

    protected function obterNomeController()
    {
        return HelperDeControllerBase::obterNomeController($this);
    }

    public function missingMethod($parametros = array())
    {
        return view("errors.503");
    }

    public function obterViewErro503()
    {
        return view("errors.503");
    }

    protected function obterParametrosBasicos()
    {
        return array('nomeController' => $this->obterNomeController());
    }

    protected function obterRota()
    {
        return HelperDeControllerBase::obterRota($this->formatarRota(), $this->rotaAdicional);
    }

    private function formatarRota()
    {
        return HelperDeControllerBase::formatarRota($this->folder);
    }

    protected function obterViewAutenticada($funcao)
    {
        if (!$this->usuarioAutenticado) {
            return $this->obterViewLogin();
        }

        return call_user_func($funcao);
    }

    protected function obterViewLogin()
    {
        return view("auth/login", ['mensagem' => 'Você foi desconectado']);
    }
}
