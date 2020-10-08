<?php

use Illuminate\Database\Seeder;

class ParametroFinanceiro extends Seeder
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
                    'naoverificarchecagemlimitecredito' => false
                ]
        ];

        DB::Table('parametrofinanceiro')->insert($sistema);
    }
}
