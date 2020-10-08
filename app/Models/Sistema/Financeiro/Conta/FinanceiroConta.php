<?php

namespace App\Models\Sistema\Financeiro\Conta;

use App\Models\BaseModelSimple;
use App\Models\Sistema\Financeiro\Banco\FinanceiroBanco;

class FinanceiroConta extends BaseModelSimple
{
    protected $fillable = array('idempresa',
                                'descricao',
                                'ativo',
                                'agencia',
                                'agenciadigito',
                                'conta',
                                'contadigito',
                                'principal',
                                'idfinanceirobanco');

               
   public function financeiroBanco()
   {
       return $this->belongsTo(FinanceiroBanco::class, 'idfinanceirobanco');
   }
                 
    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
            'agencia' => 'max:9',
            'agenciadigito' => 'max:2',
            'conta' => 'max:20',
            'contadigito' => 'max:2'
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
            'agencia' => 'Agencia',
            'agenciadigito' => 'Agencia digito',
            'conta' => 'Conta',
            'contadigito' => 'Conta digito'
        ];
    }
}