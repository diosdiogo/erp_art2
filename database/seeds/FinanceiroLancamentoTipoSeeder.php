<?php

use Illuminate\Database\Seeder;

class FinanceiroLancamentoTipoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            0 => ['descricao' => 'PAGAMENTO'],
            1 => ['descricao' => 'RECEBIMENTO'],
            2 => ['descricao' => 'TRANSFERENCIA'],
            3 => ['descricao' => 'CONTA A PAGAR'],
            4 => ['descricao' => 'CONTA A RECEBER']
        ];

        $this->obterConexao()->Table('financeirolancamentotipo')->insert($tipos);
    }
}
