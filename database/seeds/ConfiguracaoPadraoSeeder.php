<?php

use Illuminate\Database\Seeder;

class ConfiguracaoPadraoSeeder extends BaseSeedPublic
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
                'nomesistema' => 'Mobi Soft',
                'versao' => '0.0.2',
                'mininomesistema' => 'MS',
                'site' => 'http://www.mobisolucoes.com.br'
                ]
        ];

        $this->obterConexao()->Table('configuracaopadrao')->insert($sistema);
    }
}
