<?php

use Illuminate\Database\Seeder;

class ParametroMercadoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sistema = [
            0 => [
                    'permitevendacomestoquenegativo' => false
                ]
        ];

        DB::Table('parametromercadoria')->insert($sistema);
    }
}
