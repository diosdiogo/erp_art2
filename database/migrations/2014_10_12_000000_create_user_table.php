<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends BaseMigrationAtivacao
{
    public function __construct()
    {
        parent::__construct("user");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('supervisor');
            $table->string('imagem', 120)->nullable();
            $table->boolean('ativo');
            $table->integer('idempresafilial')->unsigned();
            $table->foreign('idempresafilial')->references('id')->on('ativacao.empresafilial')->onDelete('cascade')->onUpdate('cascade');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
