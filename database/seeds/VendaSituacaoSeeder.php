<?php

use Illuminate\Database\Seeder;

class VendaSituacaoSeeder extends BaseSeedPublic
{
    public function run()
    {
        $tipos = [
                   0 => ['descricao' => 'ABERTA'],
                   1 => ['descricao' => 'CONCLUIDA']
               ];

        $this->obterConexao()->Table('vendasituacao')->insert($tipos);
    }
}