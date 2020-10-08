<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecoTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("endereco");
    }
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa');
            $table->integer('idenderecotipo')->unsigned();
            $table->foreign('idenderecotipo')->references('id')->on('enderecotipo');
            $table->string('logradouro', 100);
            $table->string('numero', 15);
            $table->string('complemento', 100);
            $table->string('bairro', 70);
            $table->string('cep', 10);
            $table->string('pontoreferencia', 100);
            $table->integer('indice');
            $table->timestamps();
        });
    }
}