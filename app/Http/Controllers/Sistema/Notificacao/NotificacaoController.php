<?php

namespace App\Http\Controllers\Sistema\Notificacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;

class NotificacaoController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "notificacao";
    protected $inserir = false;
    protected $obterPorEmpresaEUsuario = true;
    
    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}
