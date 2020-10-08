<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoRegraFiscalsTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("produtoregrafiscal");
    }

    public function up()
    {
        Schema::create('produtoregrafiscal', function (Blueprint $table) {
            $table->increments('id');
            $table->string("descricao", 150);
            $table->boolean("ativo");
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
}
