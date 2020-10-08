<?php

use Illuminate\Database\Seeder;

class FinanceiroContaPagarSituacaoSeeder extends BaseSeedPublic
{
    public function run()
    {
        $financeiro = [
            0 => ['descricao' => 'EM ABERTO'],
            1 => ['descricao' => 'PAGA']
        ];

        $this->obterConexao()->Table('financeirocontapagarsituacao')->insert($financeiro);
    }
}