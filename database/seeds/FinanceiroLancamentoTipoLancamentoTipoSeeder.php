<?php

use Illuminate\Database\Seeder;

class FinanceiroLancamentoTipoLancamentoTipoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            0 => ['descricao' => 'MANUAL'],
            1 => ['descricao' => 'AUTOMATICO']
        ];

        $this->obterConexao()->Table('financeirolancamentotipolancamento')->insert($tipos);
    }
}