<?php

use Illuminate\Database\Seeder;

class EmpresaRamoAtividadeSeeder extends BaseSeedPublic
{
    public function run()
    {
        $dias = [
           0 => ['descricao' => 'AÇOUGUE'],
           1 => ['descricao' => 'MATERIAIS DE CONSTRUÇÃO'],
           2 => ['descricao' => 'TECELAGEM'],
       ];

        $this->obterConexao()->Table('empresaramoadeatividade')->insert($dias);
    }
}
