<?php

namespace App\Models\Sistema\Financeiro\ContaReceber;

use App\Models\BaseModel;
use App\Enums\FinanceiroContaReceberSituacaoEnum;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceberItem;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReberSituacao;

class FinanceiroContaReceber extends BaseModel
{
    protected $fillable = array('idempresa', 'descricao', 'idfinanceirocontagerencial', 'codigobarras', 'observacao', 'datavencimento', 'valortotal', 'documento', 'idsituacao');

    public function contaReceberItens(){
        return $this->hasMany(FinanceiroContaReceberItem::class, "idfinanceirocontareceber");
    }
    
    public function situacao(){
        return $this->belongsTo(FinanceiroContaReceberSituacao::class, 'idsituacao');
    }

    public function validarInserir(){
        return [
            'descricao' => 'required|max:100',
        ];
    }

    public function validarAlterar(){
        $situacaoPaga = FinanceiroContaReceberSituacaoEnum::PAGA;

        return [
            'descricao' => 'required|max:100',
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function validarReceber(){
        $situacaoPaga = FinanceiroContaReceberSituacaoEnum::PAGA;

        return [
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function validarAntesDeAlterar(){
        $situacaoPaga = FinanceiroContaReceberSituacaoEnum::PAGA;

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
        'idsituacao.not_in' => 'Não é possivel alterar ou deletar conta receber com situação PAGA'
    ]; 


    public function validarAntesDeDeletar(){
        $situacaoPaga = FinanceiroContaReceberSituacaoEnum::PAGA;
        
        return [
            'documento' => "size:>0",
            'idsituacao' => "not_in:$situacaoPaga"
        ];
    }

    public function alterarSituacaoPaga(){
        return $this->attributes['idsituacao'] = FinanceiroContaReceberSituacaoEnum::PAGA;
    }
}