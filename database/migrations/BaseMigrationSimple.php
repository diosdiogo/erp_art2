<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BaseMigrationSimple extends BaseMigration
{
    protected $table;

    public function __construct($table)
    {
        parent::__construct($table);
        $this->table = $table;
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('descricao', 150);
            $table->boolean('ativo');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }
}
