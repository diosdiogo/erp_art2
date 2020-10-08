<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends BaseSeedAtivacao
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = [
            0 => [
                    'name' => 'Gustavo Trevisan',
                    'email' => 'contato@gustavotrevisan.com.br',
                    'password' => Hash::make('123456'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 2,
                    'imagem' => 'mabi'
                ],
            1 => [
                    'name' => 'Wallace Silva',
                    'email' => 'w.pereira.silva@gmail.com',
                    'password' => Hash::make('w.mobi.321'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 1,
                    'imagem' => 'esquadrilar'
                ],
            2 => [
                    'name' => 'Luiz Antonio',
                    'email' => 'luiz.esquadrilar@gmail.com',
                    'password' => Hash::make('#esquadrilar@5KLQ'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 1,
                    'imagem' => 'esquadrilar'
                ],
            3 => [
                    'name' => 'Daiane',
                    'email' => 'mabidistribuidora@gmail.com',
                    'password' => Hash::make('#mabi@5KLQ'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 2,
                    'imagem' => 'mabi'
                ],
            4 => [
                    'name' => 'Suporte',
                    'email' => 'suporte@mobisolucoes.com.br',
                    'password' => Hash::make('mobi321#'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 3,
                    'imagem' => 'mabi'
                ],
            5 => [
                    'name' => 'Administrador',
                    'email' => 'campeao.administrador@mobisolucoes.com.br',
                    'password' => Hash::make('campeao321#'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 4,
                    'imagem' => 'campeao'
                ],              
            6 => [
                    'name' => 'Campeao',
                    'email' => 'ropires2909@hotmail.com',
                    'password' => Hash::make('campeao321#'),
                    'supervisor' => 1,
                    'ativo' => 1,
                    'idempresafilial' => 4,
                    'imagem' => 'campeao'
                ]                  
        ];

        $this->obterConexao()->Table('user')->insert($usuarios);
    }
}
