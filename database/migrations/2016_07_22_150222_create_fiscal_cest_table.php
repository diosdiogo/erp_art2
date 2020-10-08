<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiscalCestTable extends BaseMigrationPublic
{
    public function __construct()
    {
        parent::__construct("fiscalcest");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('codigo', 100);
            $table->string('descricao', 1000);
        });
    }
}