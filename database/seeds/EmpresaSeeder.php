<?php

use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    public function run()
    {
        $empresas = [
            0 => [
                'id' => '1',
                'razaosocial' => 'LUIZ ANTONIO OLIVIERI JUNIOR - ME',
                'nomefantasia' => 'ESQUADRILAR',
                'email' => 'luiz.esquadrilar@gmail.com',
                'cnpj' => '10471642000122',
                'emp' => '0',
                'matriz' => '1',
                'inscricaomunicipal' => '',
                'inscricaoestadual' => ''
            ]
        ];

        DB::Table('empresa')->insert($empresas);
    }
}