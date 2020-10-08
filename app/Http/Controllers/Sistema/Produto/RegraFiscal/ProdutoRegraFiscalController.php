<?php

namespace App\Http\Controllers\Sistema\Produto\RegraFiscal;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use DB;

class ProdutoRegraFiscalController extends GridUpdateBaseController
{
    protected $pasta = "Produto\\RegraFiscal";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}
