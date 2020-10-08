<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroContaReceberItem extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeirocontareceberitem");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('ordem')->nullable();

            $table->integer('idfinanceirocontareceber')->unsigned();
            $table->foreign('idfinanceirocontareceber')->references('id')->on('financeirocontareceber')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idformarecebimento')->unsigned();
            $table->foreign('idformarecebimento')->references('id')->on('financeiroformarecebimento')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('idfinanceiroconta')->unsigned()->nullable();
            $table->foreign('idfinanceiroconta')->references('id')->on('financeiroconta')->onDelete('cascade')->onUpdate('cascade');

            $table->decimal('jurosmoeda', 10, 2)->default(0);
            $table->decimal('descontomoeda', 10, 2)->default(0);
            $table->decimal('valortotal', 10, 2)->default(0);
            $table->date('datapago');

            $table->timestamps();
        });
    }
}
