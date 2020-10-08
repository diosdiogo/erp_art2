<?php

use Illuminate\Database\Seeder;

class UnidadeMedidaSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $unidades = [
            0 => [
                'descricao' => 'KILOGRAMA'
            ],
            1 => [
                'descricao' => 'UNIDADE'
            ],
            2 => [
                'descricao' => 'CAIXA'
            ],
            3 => [
                'descricao' => 'FARDO'
            ],
            4 => [
                'descricao' => 'SACO'
            ],
            4 => [
                'descricao' => 'METRO'
            ]
        ];

        $this->obterConexao()->Table('unidademedida')->insert($unidades);
    }
}
