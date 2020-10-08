<?php

namespace App\Http\Controllers\Sistema\Transportadora;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;

class TransportadoraController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "transportadora";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function obterCamposGrid(){
        return array('Codigo', 'Descricao', 'Placa');
    }
}
