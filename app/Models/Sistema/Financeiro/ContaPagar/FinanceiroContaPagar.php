<?php

namespace App\Models\Sistema\Financeiro\ContaPagar;

use App\Models\BaseModel;
use App\Enums\FinanceiroContaPagarSituacaoEnum;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagarItem;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaReberSituacao;

class FinanceiroContaPagar extends BaseModel
{
    protected $fillable = array('idempresa', 'descricao', 'idfinanceirocontagerencial', 'codigobarras', 'observacao', 'datavencimento', 'valortotal', 'documento', 'idsituacao');

    public function contaPagarItens(){
        return $this->hasMany(FinanceiroContaPagarItem::class, "idfinanceirocontapagar");
    }
    
    public function situacao(){
        return $this->belongsTo(FinanceiroContaPagarSituacao::class, 'idsituacao');
    }

    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
        ];
    }

    public function validarAlterar(){
        $situacaoPaga = FinanceiroContaPagarSituacaoEnum::PAGA;

        return [
            'descricao' => 'required|max:100',
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function validarPagar(){
        $situacaoPaga = FinanceiroContaPagarSituacaoEnum::PAGA;

        return [
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function validarAntesDeAlterar(){
        $situacaoPaga = FinanceiroContaPagarSituacaoEnum::PAGA;

        return [
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
        ];
    }

    public $mensagemAlias = [
        'documento.size' => 'Não é possivel alterar ou deletar lançamentos automáticos',
        'idsituacao.not_in' => 'Não é possivel alterar ou deletar conta pagar com situação PAGA'
    ]; 


    public function validarAntesDeDeletar(){
        $situacaoPaga = FinanceiroContaPagarSituacaoEnum::PAGA;
        
        return [
            'documento' => "size:>0",
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function alterarSituacaoPaga(){
        return $this->attributes['idsituacao'] = FinanceiroContaPagarSituacaoEnum::PAGA;
    }
}