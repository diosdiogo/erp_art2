<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuPainelTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("menupainel");
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('icone', 15);
            $table->string('iconequantidade', 15);
            $table->integer('quantidade');
            $table->string('mesangem', 50);
            $table->boolean('porcentagem');
            $table->integer('idmenupainelcor')->unsigned();
            $table->foreign('idmenupainelcor')->references('id')->on('menupainelcor');
        });*/
    }
}
