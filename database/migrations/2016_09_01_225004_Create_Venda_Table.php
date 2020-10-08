<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendaTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("venda");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('idempresa')->default(1)->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('orcamento');
            $table->string('descricao', 150);
            $table->date('datavenda');
            $table->date('dataentrega');
            $table->integer('idtransportadora')->unsigned();
            $table->foreign('idtransportadora')->references('id')->on('transportadora')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idpessoa')->unsigned();
            $table->foreign('idpessoa')->references('id')->on('pessoa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idpessoavendedor')->unsigned();
            $table->foreign('idpessoavendedor')->references('id')->on('pessoa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idformarecebimento')->unsigned();
            $table->foreign('idformarecebimento')->references('id')->on('financeiroformarecebimento')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idformarecebimentoitem')->unsigned();
            $table->foreign('idformarecebimentoitem')->references('id')->on('financeiroformarecebimentoitem')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('acrescimomoeda', 10, 2)->default(0);
            $table->decimal('descontomoeda', 10, 2)->default(0);
            $table->decimal('valortotal', 10, 2)->default(0);
            $table->string('observacao', 250);
            $table->integer('idvendasituacao')->unsigned()->default(1);
            $table->foreign('idvendasituacao')->references('id')->on('vendasituacao')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
}
