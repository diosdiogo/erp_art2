<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroContaPagarTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeirocontapagar");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('codigobarras', 100)->nullable();
            $table->string('descricao', 100);
            $table->string('observacao', 200)->nullable();
            $table->date('datavencimento');
            $table->decimal('valor', 10, 2);
            $table->integer('idfinanceirocontagerencial')->unsigned()->nullable();
            $table->foreign('idfinanceirocontagerencial')->references('id')->on('financeirocontagerencial')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idsituacao')->unsigned()->default(1);
            $table->foreign('idsituacao')->references('id')->on('financeirocontapagarsituacao')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
}