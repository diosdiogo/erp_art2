<?php

namespace App\Http\Controllers\Sistema\Parametro\Faturamento;

use App\Http\Controllers\Behavior\GridUpdateParameterBaseController;

class ParametroFaturamentoController extends GridUpdateParameterBaseController
{
    protected $pasta = "parametro\\Faturamento";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}