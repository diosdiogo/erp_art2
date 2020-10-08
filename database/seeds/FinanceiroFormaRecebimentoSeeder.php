<?php

use Illuminate\Database\Seeder;

class FinanceiroFormaRecebimentoSeeder extends Seeder
{
    public function run()
    {
           $formas = [
                    0 => [
                            'descricao' => 'AVISTA',
                            'idempresa' => 1,
                            'ativo' => 1,
                    ],
               /*     1 => ['descricao' => 'CARTAO DE CRÉDITO',
                            'idempresa' => 1,
                            'ativo' => 1,
                    ]*/];

        DB::Table('financeiroformarecebimento')->insert($formas);

           $formasitem = [
                    0 => [
                            'idformarecebimento' => '1',
                            'descricao' => '1X AVISTA',
                            'numeroparcelas' => 1,
                            'diaprimeiraparcela' => 0,
                            'utilizacompra' => true,
                            'utilizavenda' => true
                    ]];
                    
        DB::Table('financeiroformarecebimentoitem')->insert($formasitem);
    }
}
