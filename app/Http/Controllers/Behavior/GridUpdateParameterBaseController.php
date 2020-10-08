<?php

namespace App\Http\Controllers\Behavior;

use DB;
use Validator;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use \App\Models\Sistema\Parametro\Financeiro\ParametroFinanceiro;

class GridUpdateParameterBaseController extends GridUpdateBaseController
{
    public function __construct($folder)
    {
        parent::__construct($folder);

        if(count($this->model->get()) > 0)
            $this->inserir = false;
    }
}