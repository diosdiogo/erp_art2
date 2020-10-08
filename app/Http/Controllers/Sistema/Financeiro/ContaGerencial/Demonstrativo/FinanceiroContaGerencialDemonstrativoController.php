<?php

namespace App\Http\Controllers\Sistema\Financeiro\ContaGerencial\Demonstrativo;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;

class FinanceiroContaGerencialDemonstrativoController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "financeiro\\contagerencial\\demonstrativo";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}
