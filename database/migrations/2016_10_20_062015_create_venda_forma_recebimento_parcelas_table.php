<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendaFormaRecebimentoParcelasTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("vendaformarecebimentoparcela");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idvenda')->unsigned();
            $table->foreign('idvenda')->references('id')->on('venda')->onDelete('cascade')->onUpdate('cascade');
            $table->string('parcela', 50);
            $table->date('datavencimento');
            $table->decimal('valor', 10, 2);
            $table->timestamps();
        });
    }
}
