<?php

namespace App\Models\Sistema\Financeiro\ContaGerencial;

use App\Models\BaseModel;

class FinanceiroContaGerencial extends BaseModel
{
  protected $fillable = array('idempresa', 'descricao', 'ativo', 'idfinanceirodemonstrativo', 'idfinanceiromovimentotipo', 'debito', 'credito', 'compras');
               
   //public function financeiroDemonstrativo()
   //{
   //    return $this->hasOne(FinanceiroBanco::class, 'idfinanceirodemonstrativo');
   //}

   //public function financeiroMovimentoTipo()
   //{
   //    return $this->hasOne(FinanceiroBanco::class, 'idfinanceiromovimentotipo');
   //}
                 
    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
            'debito' => 'required|max:100',
            'credito' => 'required|max:100',
            'idfinanceirodemonstrativo' => 'required',
            'idfinanceiromovimentotipo' => 'required',
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
            'debito' => 'Debito',
            'credito' => 'Credito',
            'idfinanceirodemonstrativo' => 'Demonstrativo',
            'idfinanceiromovimentotipo' => 'Tipo'
        ];
    }
}