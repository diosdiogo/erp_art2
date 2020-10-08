<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaFilialTable extends BaseMigrationAtivacao
{
    public function __construct()
    {
        parent::__construct("empresafilial");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 50);
            $table->boolean('ativo');
            $table->boolean('bloqueiofinanceiro');
            $table->integer('quantidadeusuario')->default(2);
            $table->string('banco', 50);
            $table->foreign('idempresaramoadeatividade')->references('id')->on('empresaramoadeatividade')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idempresaramoadeatividade')->unsigned()->nullable();
        });
    }
}
