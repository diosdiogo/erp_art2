<?php

namespace App\Http\Controllers\Sistema\Produto\Marca;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;

class ProdutoMarcaController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "Produto\\Marca";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}
