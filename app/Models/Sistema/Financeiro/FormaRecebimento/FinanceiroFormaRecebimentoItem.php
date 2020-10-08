<?php

namespace App\Models\Sistema\Financeiro\FormaRecebimento;

use App\Models\BaseModel;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;

class FinanceiroFormaRecebimentoItem extends BaseModel
{
    protected $fillable = array('idformarecebimento',
                                'descricao',
                                'numeroparcelas',
                                'recorrencia',
                                'diaprimeiraparcela',
                                'utilizacompra',
                                'utilizavenda');

    public function formaRecebimento(){
        return $this->belongsTo(FinanceiroFormaRecebimento::class, 'idformarecebimento');
    }

}