<?php

namespace App\Http\Controllers\Sistema\Produto\Categoria;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;

class ProdutoCategoriaController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "Produto\\Categoria";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

}
