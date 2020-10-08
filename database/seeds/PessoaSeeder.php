<?php

use Illuminate\Database\Seeder;

class PessoaSeeder extends Seeder
{
    public function run()
    {
        $pessoas = [
            0 => [
                    'id' => '1',
                    'idempresa' => '1',
                    'ativo' => '1',
                    'razaosocial' => 'CONSUMIDOR FINAL',
                    'nomefantasia' => 'CONSUMIDOR FINAL',
                    'consumidorfinal' => '1',
                    'cpfoucnpj' => '',
                    'rgouinscricaoestadual' => '1',
                    'idpessoatipo' => '1',
                    'iduf' => '20'
                ],
        ];

        DB::Table('pessoa')->insert($pessoas);
    }
}
