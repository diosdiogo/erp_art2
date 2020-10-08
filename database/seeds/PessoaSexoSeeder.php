<?php

use Illuminate\Database\Seeder;

class PessoaSexoSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
                   0 => ['id' => 0, 'descricao' => '[SELECIONE]'],
                   0 => ['descricao' => 'MASCULINO'],
                   1 => ['descricao' => 'FEMININO']
               ];

        $this->obterConexao()->Table('pessoasexo')->insert($tipos);
    }
}
