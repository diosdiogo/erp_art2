<?php

namespace App\Http\Controllers\Sistema\Produto\Fornecedor;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use DB;

class ProdutoFornecedorController extends GridUpdateBaseController
{
    protected $pasta = "Produto\\Fornecedor";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}
