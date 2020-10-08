<?php

use Illuminate\Database\Seeder;

class FinanceiroContaReceberSituacaoSeeder extends BaseSeedPublic
{
    public function run()
    {
        $financeiro = [
            0 => ['descricao' => 'EM ABERTO'],
            1 => ['descricao' => 'PAGA']
        ];

        $this->obterConexao()->Table('financeirocontarecebersituacao')->insert($financeiro);
    }
}