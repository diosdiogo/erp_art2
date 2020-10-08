<?php

use Illuminate\Database\Seeder;

class FinanceiroMovimentoTipoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movimentos = [
            0 => ['descricao' => 'ENTRADA'],
            1 => ['descricao' => 'SAIDA']
        ];

        $this->obterConexao()->Table('financeiromovimentotipo')->insert($movimentos);
    }
}
