<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("pessoa");
    }
  
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->boolean('ativo');
            $table->string('razaosocial', 100);
            $table->integer('idpessoatipo')->unsigned();
            $table->foreign('idpessoatipo')->references('id')->on('pessoatipo');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa');
            $table->string('nomefantasia', 100);
            $table->string('cpfoucnpj', 14);
            $table->integer('idpessoatipocontribuinte')->unsigned()->nullable();
            $table->foreign('idpessoatipocontribuinte')->references('id')->on('pessoatipocontribuinte');
            $table->integer('idufdocumento')->unsigned()->nullable();
            $table->foreign('idufdocumento')->references('id')->on('uf');
            $table->integer('iduf')->unsigned()->nullable();
            $table->foreign('iduf')->references('id')->on('uf');
            $table->string('rgouinscricaoestadual', 20);
            $table->string('rgorgaoemissor', 4);
            $table->integer('idpessoasexo')->unsigned()->nullable();
            $table->foreign('idpessoasexo')->references('id')->on('pessoasexo');
            $table->integer('iddiadasemana')->unsigned()->nullable();
            $table->foreign('iddiadasemana')->references('id')->on('diadasemana');
            $table->date('datanascimentoouabertura', 20)->nullable();
            $table->string('site', 100);
            $table->string('celular', 50);
            $table->string('fax', 50);
            $table->string('email', 100);
            $table->boolean('ignoralimitecredito');
            $table->string('telefone', 50);
            $table->string('bairro', 70);
            $table->string('cidade', 100);
            $table->string('endereco', 100)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('pontoreferencia', 100)->nullable();
            $table->string('nomecontato', 100)->nullable();
            $table->string('cep', 100)->nullable();
            $table->decimal('limitecredito', 10, 2);
            $table->string('codigopesonalizado', 20)->nullable();
            $table->integer('idenderecotipo')->unsigned()->nullable();
            $table->foreign('idenderecotipo')->references('id')->on('enderecotipo');
            $table->integer('idpessoaramoatividade')->unsigned()->nullable();
            $table->foreign('idpessoaramoatividade')->references('id')->on('pessoaramoatividade');
            $table->boolean('consumidorfinal');
            $table->timestamps();
        });
    }
}
