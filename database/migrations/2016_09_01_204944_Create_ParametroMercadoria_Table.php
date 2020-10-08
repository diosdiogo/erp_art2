<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametroMercadoriaTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("parametromercadoria");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->unsignedInteger('idempresa')->unsigned()->nullable();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('permitevendacomestoquenegativo');
            $table->boolean('usadetalhe');
            $table->timestamps();
        });
    }
}
