<?php

use Illuminate\Database\Seeder;

class PessoaRelacaoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $relacoes = [
            0 => ['descricao' => 'CLIENTE'],
            1 => ['descricao' => 'FORNECEDOR'],
            2 => ['descricao' => 'FUNCIONÁRIO']
        ];

        $this->obterConexao()->Table('pessoarelacao')->insert($relacoes);
    }
}
