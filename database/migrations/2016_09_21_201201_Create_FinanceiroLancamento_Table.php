<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroLancamentoTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeirolancamento");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->decimal('valor', 10, 2);
            $table->decimal('jurosmoeda', 10, 2);
            $table->decimal('descontomoeda', 10, 2);
            $table->string('observacao', 100)->nullable();
            $table->string('numerodocumento', 100)->nullable();
            $table->date('datalancamento');

            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('idlancamentotipolancamento')->unsigned()->default(1);
            $table->foreign('idlancamentotipolancamento')->references('id')->on('financeirolancamentotipolancamento')->onDelete('cascade')->onUpdate('cascade');
            
            $table->integer('idfinanceirolancamentotipo')->unsigned()->nullable();
            $table->foreign('idfinanceirolancamentotipo')->references('id')->on('financeirolancamentotipo')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceirocontagerencial')->unsigned()->nullable();
            $table->foreign('idfinanceirocontagerencial')->references('id')->on('financeirocontagerencial')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceiroformarecebimento')->unsigned()->nullable();
            $table->foreign('idfinanceiroformarecebimento')->references('id')->on('financeiroformarecebimento')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceirocontaorigem')->unsigned()->nullable();
            $table->foreign('idfinanceirocontaorigem')->references('id')->on('financeiroconta')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceirocontadestino')->unsigned()->nullable();
            $table->foreign('idfinanceirocontadestino')->references('id')->on('financeiroconta')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceirodocumentotipo')->unsigned()->default(1);
            $table->foreign('idfinanceirodocumentotipo')->references('id')->on('financeirolancamentodocumentotipo')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });
    }
}