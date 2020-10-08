<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendaItemTable  extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("vendaitem");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('ordem')->nullable();
            $table->integer('idproduto')->unsigned();
            $table->foreign('idproduto')->references('id')->on('produto')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idvenda')->unsigned();
            $table->foreign('idvenda')->references('id')->on('venda')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('acrescimomoeda', 10, 2)->default(0);
            $table->decimal('descontomoeda', 10, 2)->default(0);
            $table->decimal('valorunitario', 10, 2)->default(0);
            $table->decimal('valortotal', 10, 2)->default(0);
            $table->decimal('quantidade', 10, 2)->default(0);
            $table->timestamps();
        });
    }
}
