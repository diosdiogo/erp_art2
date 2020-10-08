<?php

use Illuminate\Database\Seeder;

class ProdutoFiscalOrigemMercadoriaSeerder extends BaseSeedPublic
{
    public function run()
    {
        $origens = [
            0 => ['id' => '1', 'descricao' => 'NACIONAL'],
            1 => ['id' => '2', 'descricao' => 'ESTRANGEIRA IMPORTACAO DIRETA'],
            2 => ['id' => '3', 'descricao' => 'ESTRANGEIRA ADQUIRIDA NO MERCADO INTERNO']
        ];

        $this->obterConexao()->Table('produtofiscalorigemmercadoria')->insert($origens);
    }
}
