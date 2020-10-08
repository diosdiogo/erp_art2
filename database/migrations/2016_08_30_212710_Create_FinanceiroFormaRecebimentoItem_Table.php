<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinanceiroFormaRecebimentoItemTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("financeiroformarecebimentoitem");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('idformarecebimento')->unsigned();
            $table->foreign('idformarecebimento')->references('id')->on('financeiroformarecebimento')->onDelete('cascade')->onUpdate('cascade');
            $table->string('descricao', 100)->nullable();
            $table->integer("numeroparcelas");
            $table->integer("recorrencia");
            $table->integer("diaprimeiraparcela");
            $table->boolean("utilizacompra");
            $table->boolean("utilizavenda");
            $table->timestamps();
        });
    }
}
