<?php

use Illuminate\Database\Seeder;

class BaseSeedAtivacao extends Seeder
{
    public function run(){

    }

    protected function obterConexao(){
        return DB::connection('ativacao');
    }
}