<?php

use Illuminate\Database\Seeder;

class ProdutoFornecedorSeeder extends Seeder
{
    public function run()
    {
        $fornecedor = [
            0 => [
                    'descricao' => 'PADRAO',
                    'idempresa' => '1',
                    'ativo' => 'true',
                ],
        ];

        DB::Table('produtofornecedor')->insert($fornecedor);
    }
}