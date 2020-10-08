<?php

use Illuminate\Database\Seeder;

class EmpresaFilialSeeder extends BaseSeedAtivacao
{
    public function run()
    {
        $filiais = [
            0 => [
                'id' => '1',
                'descricao' => 'LUIZ ANTONIO OLIVIERI JUNIOR - ME',
                'ativo' => 1,
                'bloqueiofinanceiro' => 0,
                'banco' => 'emp000001',
                'quantidadeusuario' => 10
            ],
            1 => [
                'id' => '2',
                'descricao' => 'MABI',
                'ativo' => 1,
                'bloqueiofinanceiro' => 0,
                'banco' => 'emp000002',
                'quantidadeusuario' => 10
            ],
            2 => [
                'id' => '3',
                'descricao' => 'MOBI',
                'ativo' => 1,
                'bloqueiofinanceiro' => 0,
                'banco' => 'emp000003',
                'quantidadeusuario' => 10
            ],
            3 => [
                'id' => '4',
                'descricao' => 'CAMPEAO MATERIAIS DE CONSTRUCAO',
                'ativo' => 1,
                'bloqueiofinanceiro' => 0,
                'banco' => 'emp000004',
                'quantidadeusuario' => 2
            ]            
        ];

        $this->obterConexao()->Table('empresafilial')->insert($filiais);
    }
}
