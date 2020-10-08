<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroContaGerencialTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeirocontagerencial");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 100);
            $table->boolean('ativo');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idfinanceirodemonstrativo')->unsigned();
            $table->foreign('idfinanceirodemonstrativo')->references('id')->on('financeirocontagerencialdemonstrativo')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idfinanceiromovimentotipo')->unsigned();
            $table->foreign('idfinanceiromovimentotipo')->references('id')->on('financeiromovimentotipo')->onDelete('cascade')->onUpdate('cascade');
            $table->string('debito', 100);
            $table->string('credito', 100);
            $table->boolean('compras');
            $table->timestamps();
        });
    }
}
