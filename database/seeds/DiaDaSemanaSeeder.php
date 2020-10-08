<?php

use Illuminate\Database\Seeder;

class DiaDaSemanaSeeder extends BaseSeedPublic
{
    public function run()
    {
        $dias = [
           0 => ['descricao' => 'SEGUNDA'],
           2 => ['descricao' => 'TERCA'],
           3 => ['descricao' => 'QUARTA'],
           4 => ['descricao' => 'QUINTA'],
           5 => ['descricao' => 'SEXTA'],
           6 => ['descricao' => 'SABADO'],
           7 => ['descricao' => 'DOMINGO']
       ];

        $this->obterConexao()->Table('diadasemana')->insert($dias);
    }
}
