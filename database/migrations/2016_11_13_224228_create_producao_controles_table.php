<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducaoControlesTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("producaocontrole");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('idempresa')->default(1)->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->date('dataexecucao');
            $table->boolean('ativo');
            $table->string('observacao', 250);
            $table->integer('idpessoa')->unsigned();
            $table->foreign('idpessoa')->references('id')->on('pessoa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idproduto')->unsigned();
            $table->foreign('idproduto')->references('id')->on('produto')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idproducaomaquina')->unsigned();
            $table->foreign('idproducaomaquina')->references('id')->on('producaomaquina')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('estoquequantidade', 10, 2)->default(0);
            $table->timestamps();
        });
    }
}
