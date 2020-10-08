<?php

namespace App\Http\Controllers\Sistema\Produto;

use Illuminate\Http\Request;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

use App\Http\Requests;

class ProdutoEstoqueController extends GridUpdateBaseController
{
    protected $pasta = "produto";
    protected $nomeModel = "produto";
    protected $nomeUpdateViewModel = "produtoestoque";
    protected $rotaAcao = "produto";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}