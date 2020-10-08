<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroBancoTable extends BaseMigrationPublic
{
    public function __construct()
    {
        parent::__construct("financeirobanco");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('codigobanco', 100);
            $table->string('descricao', 100);
        });
    }
}