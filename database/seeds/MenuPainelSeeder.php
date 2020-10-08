<?php

use Illuminate\Database\Seeder;

class MenuPainelSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cores = [
            0 => ['descricao' => 'bg-red'],
            1 => ['descricao' => 'bg-yello'],
            2 => ['descricao' => 'bg-aqua'],
            3 => ['descricao' => 'bg-blue'],
            4 => ['descricao' => 'bg-light'],
            5 => ['descricao' => 'bg-green'],
            6 => ['descricao' => 'bg-navy'],
            7 => ['descricao' => 'bg-teal'],
            8 => ['descricao' => 'bg-olive'],
            9 => ['descricao' => 'bg-lime'],
            11 => ['descricao' => 'bg-orange'],
            12 => ['descricao' => 'bg-fuchsia'],
            13 => ['descricao' => 'bg-purple'],
            14 => ['descricao' => 'bg-maroon'],
            15 => ['descricao' => 'bg-black']
        ];

        $this->obterConexao()->Table('menupainelcor')->insert($cores);
    }
}
