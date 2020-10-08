<?php

use Illuminate\Database\Seeder;

class ProdutoFiscalTipoSeerder extends BaseSeedPublic
{
    public function run()
    {
        $tipos = [
          //0 => ['id' => '0', 'descricao' => 'SELECIONE'],
          1 => ['id' => '9', 'descricao' => 'ATIVO IMOBILIZADO'],
          2 => ['id' => '3', 'descricao' => 'EMBALAGEM'],
          3 => ['id' => '16', 'descricao' => 'GARRAFA'],
          4 => ['id' => '2', 'descricao' => 'MATERIA-PRIMA'],
          5 => ['id' => '8', 'descricao' => 'MATERIAL DE USO E CONSUMO'],
          6 => ['id' => '1', 'descricao' => 'MERCADORIA PARA REVENDA'],
          7 => ['id' => '12', 'descricao' => 'OUTRAS'],
          8 => ['id' => '11', 'descricao' => 'OUTROS INSUMOS'],
          9 => ['id' => '5', 'descricao' => 'PRODUTO ACABADO'],
          10 => ['id' => '4', 'descricao' => 'PRODUTO EM PROCESSO'],
          11 => ['id' => '7', 'descricao' => 'PRODUTO INTERMEDIARIO'],
          12 => ['id' => '10', 'descricao' => 'SERVICOS'],
          13 => ['id' => '6', 'descricao' => 'SUBPRODUTO']
      ];

        $this->obterConexao()->Table('produtofiscaltipo')->insert($tipos);
    }
}
