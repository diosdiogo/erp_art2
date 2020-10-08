<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFiscalNaturezaOperacaosTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("fiscalnaturezaoperacao");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string("descricao", 150);
            $table->boolean("ativo");
            $table->boolean("emissaopropria");

            $table->integer('idfiscalCFOPDentroEstado')->unsigned();
            $table->foreign('idfiscalCFOPDentroEstado')->references('id')->on('fiscalCFOP')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfiscalCFOPForaEstado')->unsigned();
            $table->foreign('idfiscalCFOPForaEstado')->references('id')->on('fiscalCFOP')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceiromovimentotipo')->unsigned();
            $table->foreign('idfinanceiromovimentotipo')->references('id')->on('financeiromovimentotipo')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }
}
