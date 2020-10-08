<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutoTable extends BaseMigration
{
    public function __construct()
    {
        parent::__construct("produto");
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id')->unique();
            
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idprodutoregrafiscal')->unsigned()->nullable();
            $table->foreign('idprodutoregrafiscal')->references('id')->on('produtoregrafiscal')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idprodutomarca')->unsigned()->nullable();
            $table->foreign('idprodutomarca')->references('id')->on('produtomarca')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idunidademedida')->unsigned();
            $table->foreign('idunidademedida')->references('id')->on('unidademedida')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idprodutocategoria')->unsigned()->nullable();
            $table->foreign('idprodutocategoria')->references('id')->on('produtocategoria')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idpessoafornecedor')->unsigned()->nullable();
            $table->foreign('idpessoafornecedor')->references('id')->on('pessoa')->onDelete('cascade')->onUpdate('cascade');
            $table->string('descricao', 150);
            $table->string('codigoreduzido', 20)->nullable();
            $table->string('codigobarra', 100)->nullable();
            $table->string('descricaoadicional', 15)->nullable();
            $table->boolean('ativo');
            $table->decimal('custocompra', 10, 2);
            $table->decimal('preco', 10, 2);
            $table->string('modelo', 100)->nullable();
            $table->decimal('estoquequantidade')->nullable()->default(0);
            $table->bigInteger('estoqueunidade')->nullable()->default(0);
            $table->bigInteger('estoquequantidadecaixa')->nullable();
            $table->boolean('habilitabalanca');
            $table->string('codigobalanca', 5);
            $table->boolean('habilitapdv');
            $table->boolean('habilitacontroleestoque');
            $table->boolean('habilitanf');
            $table->integer('idorigemmercadoria')->unsigned()->nullable();
            $table->foreign('idorigemmercadoria')->references('id')->on('produtofiscalorigemmercadoria')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idprodutofiscaltipo')->unsigned()->nullable();
            $table->foreign('idprodutofiscaltipo')->references('id')->on('produtofiscaltipo')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idfiscalncm')->unsigned()->nullable();
            $table->foreign('idfiscalncm')->references('id')->on('fiscalncm')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('idfiscalcest')->unsigned()->nullable();
            $table->foreign('idfiscalcest')->references('id')->on('fiscalcest')->onDelete('cascade')->onUpdate('cascade');
            $table->string('codigofornecedor', 20)->nullable();
            $table->string('descricaofornecedor', 100)->nullable();
            $table->decimal('peso')->nullable();
            $table->decimal('largura')->nullable();
            $table->decimal('altura')->nullable();
            $table->decimal('comprimento')->nullable();
            $table->string('observacao', 255)->nullable();

            $table->timestamps();
        });
    }
}
