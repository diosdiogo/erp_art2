<?php

use Illuminate\Database\Seeder;

class BaseSeedPublic extends Seeder
{
    public function run(){
        
    }

    protected function obterConexao(){
        return DB::connection('sistema');
    }
}