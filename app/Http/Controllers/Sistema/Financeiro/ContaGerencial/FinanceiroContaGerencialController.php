<?php

namespace App\Http\Controllers\Sistema\Financeiro\ContaGerencial;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;

class FinanceiroContaGerencialController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "financeiro\\contagerencial";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}