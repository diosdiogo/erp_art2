<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnderecoTipoTable extends BaseMigrationPublic
{
    public function __construct()
    {
        parent::__construct("enderecotipo");
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 50);
        });
    }
}
