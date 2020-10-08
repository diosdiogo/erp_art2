<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroContaTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeiroconta");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idfinanceirobanco')->unsigned()->nullable();
            $table->foreign('idfinanceirobanco')->references('id')->on('financeirobanco')->onDelete('cascade')->onUpdate('cascade');
            $table->string('descricao', 100);
            $table->string('agencia', 9)->nullable();
            $table->string('agenciadigito', 2)->nullable();
            $table->string('conta', 20)->nullable();
            $table->string('contadigito', 2)->nullable();
            $table->boolean('ativo');
            $table->boolean('internomobi');
            $table->boolean('principal');
            $table->timestamps();
        });
    }
}