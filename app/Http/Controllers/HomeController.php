<?php

namespace App\Http\Controllers;

use App\Models\Sistema\Notificacao\Notificacao;

class HomeController extends Behavior\BaseAuthController
{
    protected $pasta = "";
    protected $inicializarModel = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
        $this->middleware('auth');
    }

    public function getAlterarnotificacoesparalida(){
        Notificacao::AlterarNotificacoesParaLida();
    }
}