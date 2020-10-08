<?php

namespace App\Http\Controllers\Sistema\Parametro\Mercadoria;
use \App\Models\Sistema\Parametro\Financeiro\ParametroFinanceiro;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;
use App\ViewModel\Parametro\Financeiro\UpdateParametroFinanceiroViewModel;

class ParametroMercadoriaController extends Behavior\GridUpdateParameterBaseController
{
    protected $pasta = "parametro\\Mercadoria";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}