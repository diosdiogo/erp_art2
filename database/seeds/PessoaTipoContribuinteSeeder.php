<?php

use Illuminate\Database\Seeder;

class PessoaTipoContribuinteSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contribuintes = [
            0 => ['descricao' => 'NAO CONTRIBUINTE'],
            1 => ['descricao' => 'CONTRIBUINTE DO ICMS'],
            2 => ['descricao' => 'CONTRIBUINTE INSENTO DE INSCRICAO']
        ];

        $this->obterConexao()->Table('pessoatipocontribuinte')->insert($contribuintes);
    }
}
