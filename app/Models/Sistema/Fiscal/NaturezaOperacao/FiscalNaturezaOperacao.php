<?php

namespace App\Models\Sistema\Fiscal\NaturezaOperacao;

use App\Models\BaseModel;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;
use App\Models\Sistema\Fiscal\NaturezaOperacao\NaturezaOperacaoFinalidade;

class FiscalNaturezaOperacao extends BaseModel
{
        protected $fillable = ['ativo',
                        'idempresa',
                        'descricao',
                        'emissaopropria',
                        'idfiscalCFOPDentroEstado',
                        'idfiscalCFOPForaEstado',
                        'idfinanceiromovimentotipo',
                        'idnaturezaoperacaofinalidade'];

    public function fiscalCFOPDentroEstado()
    {
        return $this->belongsTo(FiscalCFOP::class, 'idfiscalCFOPDentroEstado');
    }

    public function naturezaOperacaoFinalidade()
    {
        return $this->belongsTo(NaturezaOperacaoFinalidade::class, 'idnaturezaoperacaofinalidade');
    }

    public function fiscalCFOPForaEstado()
    {
        return $this->belongsTo(FiscalCFOP::class, 'idfiscalCFOPForaEstado');
    }              

    public function validarInserir(){
        return [
            'descricao' => 'required|unique:fiscalnaturezaoperacao,descricao|max:150',
            'idfiscalCFOPDentroEstado' =>  'required|integer',
            'idfiscalCFOPForaEstado' =>  'required|integer',
            'idfinanceiromovimentotipo' => 'required|integer',
        ];
    }    

    public function validarAlias(){
        return [
            'descricao' => 'Descricao',
            'idfiscalCFOPDentroEstado' => 'CFOP Dentro do estado',
            'idfiscalCFOPForaEstado' => 'CFOP Fora do estado',
            'idfinanceiromovimentotipo' => 'Tipo de operação'
        ];
    }
}
