<?php

namespace App\Http\Controllers\Sistema\Parametro\Fiscal;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use \App\Models\Sistema\Parametro\Financeiro\ParametroFinanceiro;
use App\Http\Controllers\Behavior\GridUpdateParameterBaseController;
use App\ViewModel\Parametro\Financeiro\UpdateParametroFinanceiroViewModel;

class ParametroFiscalController extends GridUpdateParameterBaseController
{
    protected $pasta = "parametro\\Fiscal";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}