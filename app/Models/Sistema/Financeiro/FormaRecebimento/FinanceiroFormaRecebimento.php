<?php

namespace App\Models\Sistema\Financeiro\FormaRecebimento;

use App\Models\BaseModelSimple;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItem;
use App\Models\Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipo;
class FinanceiroFormaRecebimento extends BaseModelSimple
{
    protected $fillable = array('idempresa', 'descricao', 'ativo', 'idfinanceirotipo');

    public function formarecebimentoitens(){
        return $this->hasMany(FinanceiroFormaRecebimentoItem::class, "idformarecebimento");
    }

    public function tipo(){
        return $this->belongsTo(FinanceiroFormaRecebimentoTipo::class, 'idfinanceirotipo');
    }

    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }
}