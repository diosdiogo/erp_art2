<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoMarcaTable extends BaseMigration {

    public function __construct()
    {
        parent::__construct("produtomarca");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 150);
            $table->boolean('ativo');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
}