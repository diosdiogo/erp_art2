<?php

use Illuminate\Database\Seeder;

class UFSeeder extends BaseSeedPublic
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ufs = [
            0 => ['descricao' => 'AC'],
            1 => ['descricao' => 'AL'],
            2 => ['descricao' => 'AP'],
            3 => ['descricao' => 'AM'],
            4 => ['descricao' => 'BA'],
            5 => ['descricao' => 'CE'],
            6 => ['descricao' => 'DF'],
            7 => ['descricao' => 'ES'],
            8 => ['descricao' => 'GO'],
            9 => ['descricao' => 'MA'],
            10 => ['descricao' => 'MT'],
            11 => ['descricao' => 'MS'],
            12 => ['descricao' => 'MG'],
            13 => ['descricao' => 'PR'],
            14 => ['descricao' => 'PB'],
            15 => ['descricao' => 'PA'],
            16 => ['descricao' => 'PE'],
            17 => ['descricao' => 'PI'],
            18 => ['descricao' => 'RJ'],
            19 => ['descricao' => 'RN'],
            20 => ['descricao' => 'RS'],
            21 => ['descricao' => 'RO'],
            22 => ['descricao' => 'RR'],
            23 => ['descricao' => 'SC'],
            24 => ['descricao' => 'SE'],
            25 => ['descricao' => 'SP'],
            26 => ['descricao' => 'TO']
        ];

        $this->obterConexao()->Table('uf')->insert($ufs);
    }
}
