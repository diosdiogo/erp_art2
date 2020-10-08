<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParametroFinanceiroTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("parametrofinanceiro");
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
            $table->unsignedInteger('idempresa')->unsigned()->nullable();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('naoverificarchecagemlimitecredito');
            $table->timestamps();
        });
    }
}
