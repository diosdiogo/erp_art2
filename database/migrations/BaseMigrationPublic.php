<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseMigrationPublic extends Migration
{
    protected $table;
    protected $conexao = 'sistema';

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function down()
    {
        $teste = $this->obterConexaoPublic();
        $x = $this->conexao.'.'.$this->table;
        $teste->dropIfExists($x);
    }

    protected function obterConexaoPublic(){
        return Schema::connection($this->conexao);
    }
}
