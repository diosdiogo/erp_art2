<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificacaoTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("notificacao");
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
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idusuario')->unsigned();
            $table->foreign('idusuario')->references('id')->on('ativacao.user')->onDelete('cascade')->onUpdate('cascade');
            $table->string('titulo', 30);
            $table->string('texto', 150);
            $table->boolean('lida');
            $table->timestamps();
        });
    }
}