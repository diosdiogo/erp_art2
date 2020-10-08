<?php

namespace App\Models\Sistema\Financeiro\ContaReceber;

use App\Models\BaseModel;
use App\Models\Sistema\Financeiro\Conta\FinanceiroConta;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;

class FinanceiroContaReceberItem extends BaseModel
{
    protected $fillable = array('ordem', 'idfinanceirocontareceber', 'idformarecebimento', 'idfinanceiroconta', 'jurosmoeda', 'descontomoeda', 'valortotal', 'datapago');

    public function financeiroConta(){
        return $this->belongsTo(FinanceiroConta::class, 'idfinanceiroconta');
    }

    public function financeiroFormaRecebimento(){
        return $this->belongsTo(FinanceiroFormaRecebimento::class, 'idformarecebimento');
    }
  
    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }
}