<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaEPessoaRelacaoTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("pessoaepessoarelacao");
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
            $table->integer('idpessoa')->unsigned();
            $table->foreign('idpessoa')->references('id')->on('pessoa')->onDelete('cascade')->onUpdate('cascade');;
            $table->integer('idpessoarelacao')->unsigned();
            $table->foreign('idpessoarelacao')->references('id')->on('pessoarelacao')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
