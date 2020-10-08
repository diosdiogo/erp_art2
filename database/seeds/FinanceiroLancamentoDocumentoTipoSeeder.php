<?php

use Illuminate\Database\Seeder;

class FinanceiroLancamentoDocumentoTipoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
            0 => ['descricao' => 'PADRAO'],
            1 => ['descricao' => 'VENDA'],
            2 => ['descricao' => 'NFE']
        ];

        $this->obterConexao()->Table('financeirolancamentodocumentotipo')->insert($tipos);
    }
}