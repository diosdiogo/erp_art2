<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNCMTable extends BaseMigrationPublic
{
    public function __construct()
    {
        parent::__construct("fiscalncm");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('codigo', 100);
            $table->string('descricao', 100);
        });
    }
}