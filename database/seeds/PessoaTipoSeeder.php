<?php

use Illuminate\Database\Seeder;

class PessoaTipoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pessoatipo = [
            0 => ['descricao' => 'FISICA'],
            1 => ['descricao' => 'JURIDICA']
        ];

       $this->obterConexao()->Table('pessoatipo')->insert($pessoatipo);
    }
}
