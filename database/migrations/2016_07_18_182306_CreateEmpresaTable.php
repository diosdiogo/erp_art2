<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("empresa");
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
            $table->string('razaosocial', 50);
            $table->string('nomefantasia', 50);
            $table->string('email', 50);
            $table->string('cnpj', 14);
            $table->boolean('emp');
            $table->boolean('matriz');
            $table->string('inscricaomunicipal', 14);
            $table->string('inscricaoestadual', 14);
            $table->string('telefone', 50);
            $table->string('bairro', 70);
            $table->string('cidade', 100);
            $table->string('endereco', 100)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('pontoreferencia', 100)->nullable();
            $table->string('nomecontato', 100)->nullable();
            $table->string('cep', 100)->nullable();
            $table->foreign('idfiscalregimetributario')->references('id')->on('fiscalregimetributario')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idfiscalregimetributario')->unsigned()->nullable();
            $table->foreign('idempresaramoadeatividade')->references('id')->on('empresaramoadeatividade')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idempresaramoadeatividade')->unsigned()->nullable();
            $table->string('descricaorelatorio', 1000)->nullable();
            $table->timestamps();
        });

    }
}

