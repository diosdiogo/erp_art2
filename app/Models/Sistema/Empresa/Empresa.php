<?php

namespace App\Models\Sistema\Empresa;

use App\Models\BaseModel;
use App\Models\Sistema\Endereco\Cidade;
use App\Enums\FiscalRegimeTributarioEnum;
use App\Models\Sistema\Fiscal\CNAE\FiscalCNAE;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;

class Empresa extends BaseModel
{
    protected $fillable = array('razaosocial',
                                'nomefantasia',
                                'email',
                                'cnpj',
                                'matriz',
                                'inscricaomunicipal',
                                'inscricaoestadual',
                                'telefone',
                                'bairro',
                                'cidade',
                                'endereco',
                                'numero',
                                'complemento',
                                'pontoreferencia',
                                'nomecontato',
                                'cep',
                                'idfiscalregimetributario',
                                'idempresaramoadeatividade',
                                'idambiente',
                                'idcidade',
                                'idcnae',
                                'senha',
                                'descricaorelatorio',
                                'fraserelatorio',
                                'aliquotasimplesnacional',
                                'idfiscalcfopdentroestado',
                                'idfiscalcfopforaestado');

    public function fiscalCFOPDentroEstado()
    {
        return $this->belongsTo(FiscalCFOP::class, 'idfiscalcfopdentroestado');
    }

    public function fiscalCFOPForaEstado()
    {
        return $this->belongsTo(FiscalCFOP::class, 'idfiscalcfopforaestado');
    }

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'idcidade');
    }

    public function cnae(){
        return $this->belongsTo(FiscalCNAE::class, 'idcnae');
    }

    public function validarInserir(){
        return [
            'razaosocial' => 'required',
            'nomefantasia' => 'required',
            'email' => 'required',
            //'cnpj' => 'required',
            //'inscricaomunicipal' => 'required',
            'inscricaoestadual' => 'required',
            'telefone' => 'required',
            'bairro' => 'required',
            //'cidade' => 'required',
            'cep' => 'required'
        ];
    }

    public function validarAlterar(){
        return [
            'razaosocial' => 'required',
            'nomefantasia' => 'required',
            'email' => 'required',
            //'cnpj' => 'required',
            //'inscricaomunicipal' => 'required',
            'inscricaoestadual' => 'required',
            'telefone' => 'required',
            'bairro' => 'required',
            //'cidade' => 'required',
            'cep' => 'required'
        ];
    }

    public function validarAlias(){
        return [
            'razaosocial' => 'Razão social',
            'nomefantasia' => 'Nome fantasia',
            'email' => 'email',
            'cnpj' => 'CNPJ',
            'inscricaomunicipal' => 'Inscrição municipal',
            'inscricaoestadual' => 'Inscrição estadual',
            'telefone' => 'Telefone',
            'bairro' => 'Bairro',
            'cidade' => 'Cidade',
            'cep' => 'CEP'
        ];
    }

    public $mensagemAlias = [
        'id.size' => 'Não é permitido deletar empresa, por favor, entre em contato com a revenda.'
    ];

    public function validarAntesDeDeletar(){
        return [
            'id' => "size:>0"
        ];
    }

    public function isSimplesNacional(){
        return $this->attributes['idfiscalregimetributario'] == FiscalRegimeTributarioEnum::SIMPLESNACIONAL;
    }
}