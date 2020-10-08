<?php

namespace App\Http\Controllers\Sistema\Parametro\Financeiro;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Behavior;
use \App\Models\Sistema\Parametro\Financeiro\ParametroFinanceiro;
use App\ViewModel\Parametro\Financeiro\UpdateParametroFinanceiroViewModel;

class ParametroFinanceiroController extends Behavior\GridUpdateParameterBaseController
{
    protected $pasta = "parametro\\Financeiro";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}