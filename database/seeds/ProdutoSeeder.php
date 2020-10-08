<?php

use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run()
    {
        $produto = [
            0 => [
                    'descricao' => 'DIVERSOS',
                    'idunidademedida' => '2',
                    'idempresa' => '1',
                    'ativo' => 'true',
                    'estoquequantidade' => '100'
                ],
        ];

        DB::Table('produto')->insert($produto);
    }
}
