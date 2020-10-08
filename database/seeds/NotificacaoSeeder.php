<?php

use Illuminate\Database\Seeder;

class NotificacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notificacao = [
            0 => [
                    'id' => '1',
                    'idempresa' => '1',
                    'idusuario' => '1',
                    'titulo' => 'Seja bem-vindo',
                    'texto' => 'Sistema feito exclusivamente para você!'
                ],
            1 => [
                    'id'=> '2',
                    'idempresa' => '1',
                    'idusuario' => '1',
                    'titulo' => 'Teste',
                    'texto' => 'Teste dois'
                ]
        ];

        DB::Table('notificacao')->insert($notificacao);
    }
}
