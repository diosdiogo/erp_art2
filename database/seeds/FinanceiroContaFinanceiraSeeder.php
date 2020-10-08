<?php

use Illuminate\Database\Seeder;

class FinanceiroContaFinanceiraSeeder extends Seeder
{
    public function run()
    {
           $contas = [
                    0 => [
                            'descricao' => 'CAIXA',
                            'idempresa' => 1,
                            'ativo' => 1,
                            'internomobi' => 1
                    ],
                    1 => ['descricao' => 'PDV',
                            'idempresa' => 1,
                            'ativo' => 1,
                            'internomobi' => 0
                    ]];

        DB::Table('financeiroconta')->insert($contas);
    }
}
