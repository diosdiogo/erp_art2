<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoFornecedorsTable extends BaseMigrationSimple {

    public function __construct()
    {
        parent::__construct("produtofornecedor");
    }
}