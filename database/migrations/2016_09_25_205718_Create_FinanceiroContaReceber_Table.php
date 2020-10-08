<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroContaReceberTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeirocontareceber");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('codigobarras', 100)->nullable();
            $table->string('descricao', 100)->nullable();
            $table->string('observacao', 200)->nullable();
            $table->date('datavencimento');
            $table->decimal('valortotal', 15, 2);
            $table->string('documento', 100)->nullable();
            $table->integer('idfinanceirocontagerencial')->unsigned()->nullable();
            $table->foreign('idfinanceirocontagerencial')->references('id')->on('financeirocontagerencial')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idsituacao')->unsigned()->default(1);
            $table->foreign('idsituacao')->references('id')->on('financeirocontarecebersituacao')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
}
