<?php

namespace App\Http\Controllers\Behavior\Contrato;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;

interface IGridBaseController
{
    public function getObtergridpesquisa(ParametrosGrid $request);
}
