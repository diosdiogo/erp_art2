<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfiguracaoPadraoTable extends BaseMigrationPublic
{
    public function __construct()
    {
        parent::__construct("configuracaopadrao");
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->obterConexaoPublic()->create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('nomesistema', 20);
            $table->string('mininomesistema', 20);
            $table->string('versao', 10);
            $table->string('site', 30);
            $table->timestamps();
        });
    }

}
