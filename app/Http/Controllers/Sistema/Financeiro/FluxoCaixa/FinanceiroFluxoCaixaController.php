<?php

namespace App\Http\Controllers\Sistema\Financeiro\FluxoCaixa;


use Illuminate\Http\Request;

use App\Http\Requests;

class FinanceiroFluxoCaixaController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "financeiro\\fluxocaixa";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}