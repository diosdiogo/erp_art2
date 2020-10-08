<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroFormaRecebimentoTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeiroformarecebimento");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->string('descricao', 100)->nullable();
            $table->boolean("ativo");
            $table->timestamps();
        });
    }
}