<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseMigrationAtivacao extends Migration
{
    protected $table;
    protected $conexao = 'ativacao';

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function down()
    {
        $this->obterConexaoPublic()->dropIfExists($this->table);
    }

    protected function obterConexaoPublic(){
        return Schema::connection($this->conexao);
    }
}
