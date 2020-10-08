<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeMedidaTable extends BaseMigrationPublic
{
    public function __construct()
    {
        parent::__construct("unidademedida");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 100);
            $table->timestamps();
        });
    }
}