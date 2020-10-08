<?php

namespace App\Models\Sistema\Venda;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipo;

class VendaFormaRecebimentoParcela extends BaseModel
{
    protected $fillable = ['idvenda', 'parcela', 'datavencimento', 'valor', 'idfinanceirotipo'];

    public function validarInserir(){
        return [
            'idfinanceirotipo' => 'required',
        ];
    }

    public function financeiroTipo(){
        return $this->belongsTo(FinanceiroFormaRecebimentoTipo::class, 'idfinanceirotipo');
    }

    public function validarAlterar(){
        return [
            'idfinanceirotipo' => 'required',
        ];
    }

    public $mensagemAlias = [
        'idfinanceirotipo.required' => '[FORMA RECEBIMENTO] É necessario preencher o tipo da espécie.',
    ]; 

}
