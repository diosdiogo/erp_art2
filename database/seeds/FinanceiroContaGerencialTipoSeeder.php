<?php

use Illuminate\Database\Seeder;

class FinanceiroContaGerencialTipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipos = [
                    0 => [
                            'descricao' => 'IMPOSTOS E DEVOLUÇÕES',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    1 => ['descricao' => 'UTILIDADES',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    2 => ['descricao' => 'ALUGUEL, CONDOMÍNIO E IPTU',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    3 => ['descricao' => 'GERAIS E ADMINISTRATIVAS',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    4 => ['descricao' => 'DESPESAS FINANCEIRAS',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    5 => ['descricao' => 'PESSOAL',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    6 => ['descricao' => 'PROPAGANDA E MARKETING',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    7 => ['descricao' => 'UTILIDADES',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    8 => ['descricao' => 'CUSTO DA MERCADORIA',
                            'idempresa' => 1,
                            'ativo' => 1
                    ],
                    9 => ['descricao' => 'ENTRADA',
                            'idempresa' => 1,
                            'ativo' => 1
                    ]];

        DB::Table('financeirocontagerencialdemonstrativo')->insert($tipos);
    }
}
