<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseMigrationSimplesSistema extends BaseMigrationPublic
{
    protected $table;

    public function __construct($table)
    {
        parent::__construct($table);
        $this->table = $table;
    }

    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 100);
        });
    }
}
