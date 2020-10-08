<?php

use Illuminate\Database\Seeder;

class TransportadoraSeeder extends Seeder
{
    public function run()
    {
        $transportadora = [
            0 => [
                    'id' => '1',
                    'idempresa' => '1',
                    'ativo' => '1',
                    'descricao' => 'TRANSPORTADORA (PROPRIO)',
                    'placa' => 'AAAA000',
                ],
        ];

        DB::Table('transportadora')->insert($transportadora);
    }
}
