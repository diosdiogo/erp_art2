<?php

use Illuminate\Database\Seeder;

class EnderecoTipoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $enderecoTipo = [
            0 => ['descricao' => 'COMERCIAL'],
            1 => ['descricao' => 'RESIDENCIAL']
        ];

        $this->obterConexao()->Table('enderecotipo')->insert($enderecoTipo);
    }
}
