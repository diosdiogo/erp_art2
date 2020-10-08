<?php

use Illuminate\Database\Seeder;

class FiscalRegimeTributarioSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movimentos = [
            0 => ['descricao' => 'SIMPLES NACIONAL'],
            1 => ['descricao' => 'SIMPLES NACIONAL - EXCESSO DE SUBLIMITE DA RECEITA BRUTA'],
            2 => ['descricao' => 'REGIME NORMAL']
        ];

        $this->obterConexao()->Table('fiscalregimetributario')->insert($movimentos);
    }
}
