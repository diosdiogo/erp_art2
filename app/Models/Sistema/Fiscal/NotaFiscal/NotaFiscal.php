<?php

namespace App\Models\Sistema\Fiscal\NotaFiscal;

use App\Models\BaseModel;
use App\Models\Sistema\Venda\Venda;
use App\Enums\NotaFiscalSituacaoEnum;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Empresa\Empresa;
use App\Models\Sistema\Endereco\Cidade;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscalItem;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscalSituacao;
use App\Models\Sistema\Fiscal\NaturezaOperacao\FiscalNaturezaOperacao;

class NotaFiscal extends BaseModel
{
        public $itens;
        protected $fillable = [ 'idempresa',
                                'dataemissao',
                                'datamovimentacao',
                                'numerodocumentoorigem',
                                'observacao',
                                'idnotafiscaltipomovimentacao',
                                'idpessoa',
                                'idvenda',
                                'chaveacesso',
                                'justificativacancelamento',
                                'justificativainutilizacao',
                                'xmlenvio',
                                'xmlretorno',
                                'endereco',
                                'numero',
                                'complemento',
                                'bairro',
                                'cep',
                                'idcidade',
                                'telefone',
                                'email',
                                'inscricaomunicipal',
                                'iduf',
                                'idnotafiscalsituacao',
                                'numerorecibo',
                                'numeroprotocolo',
                                'chavecontigencia',
                                'correcao',
                                'codigostatusretorno',
                                'motivoretorno',
                                'valortotal',
                                'datahoraretorno',
                                'NUMERONF'
                                ];

   public function notaFiscalItens(){
       $this->itens = $this->hasMany(NotaFiscalItem::class, "idnotafiscal");
       return $this->itens;
    }

    public function situacao(){
        return $this->belongsTo(NotaFiscalSituacao::class, 'idnotafiscalsituacao');
    }

    public function naturezaOperacao(){
        return $this->belongsTo(FiscalNaturezaOperacao::class, 'idnaturezaoperacao');
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'idempresa');
    }

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'idcidade');
    }

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'idpessoa');
    }

    public function venda(){
        return $this->belongsTo(Venda::class, 'idvenda');
    }

    public function validarInserir(){
        return [
            'idpessoa' => 'required',
        ];
    }

    public function validarAlterar(){
        return [
            'notafiscalitens' => 'required',
            'idpessoa' => 'required',
            'idnotafiscalsituacao' => "not_in:" . NotaFiscalSituacaoEnum::AUTORIZADA . "," . NotaFiscalSituacaoEnum::CANCELADA . "," . NotaFiscalSituacaoEnum::DENEGADA
        ];
    }

    public function validarAntesDeAlterar(){
        return [
            'idnotafiscalsituacao' => "not_in:" . NotaFiscalSituacaoEnum::AUTORIZADA . "," . NotaFiscalSituacaoEnum::CANCELADA . "," . NotaFiscalSituacaoEnum::DENEGADA
        ];
    }

    public function validarAntesDeDeletar(){
        return [
            'idnotafiscalsituacao' => "not_in:" . NotaFiscalSituacaoEnum::AUTORIZADA . "," . NotaFiscalSituacaoEnum::CANCELADA . "," . NotaFiscalSituacaoEnum::DENEGADA
        ];
    }

    public function validarAlias(){
        return [
                'idpessoa' => 'Pessoa',
            ];
    }

    public $mensagemAlias = [
        'notafiscalitens.required' => 'É necessario adicionar pelo menos 1 item [Itens (Produto)]',
        'idnotafiscalsituacao.not_in' => 'Não é possivel alterar ou deletar notas fiscais com a situação AUTORIZADA, CANCELADA e DENEGADA'
    ];

    public function inserirRetorno($retorno){
        $retorno = (array) $retorno;
        $this->attributes['chaveacesso'] = $retorno['chNFe'] ?? '';
        $this->attributes['codigostatusretorno'] = $retorno['cStat'];
        $this->attributes['motivoretorno'] = $retorno['xMotivo'];
        $this->attributes['datahoraretorno'] = $retorno['dhRecbto'];
        $this->attributes['numeroprotocolo'] = $retorno['nProt'] ?? '';
        $this->atribuirSituacao($retorno['cStat']);
    }

    public function inserirRetornoCancelamento($retorno){
        if(!$this->isSituacaoCancelada()){
            $this->attributes['codigostatusretorno'] = $retorno['cStat'];
            $this->attributes['motivoretorno'] = $retorno['xMotivo'];
            $this->attributes['datahoraretorno'] = $retorno['dhRegEvento'];
            $this->atribuirSituacao($retorno['cStat']);
        }
    }

    public function atribuirSituacao($cStat){
        $idnotafiscalsituacao = NotaFiscalSituacaoEnum::ENVIAR;

        switch ($cStat) {
            case '100':
                $idnotafiscalsituacao = NotaFiscalSituacaoEnum::AUTORIZADA;
                break;
            case '101':
            case '135':
                $idnotafiscalsituacao = NotaFiscalSituacaoEnum::CANCELADA;
                break;
            case '106':
                $idnotafiscalsituacao = NotaFiscalSituacaoEnum::NAOENCONTRADA;
                break;
            case '110':
            case '301':
            case '302':
                $idnotafiscalsituacao = NotaFiscalSituacaoEnum::DENEGADA;
            default:
                $idnotafiscalsituacao = NotaFiscalSituacaoEnum::REJEICAO;
                break;
        }

        $this->attributes['idnotafiscalsituacao'] = $idnotafiscalsituacao;
    }

    public function isSituacaoAutorizada(){
        return $this->attributes['idnotafiscalsituacao'] == NotaFiscalSituacaoEnum::AUTORIZADA;
    }

    public function isSituacaoCancelada(){
        return $this->attributes['idnotafiscalsituacao'] == NotaFiscalSituacaoEnum::CANCELADA;
    }

    public function obterValorTotal(){
        return $this->itens->sum('valortotalitem');
    }
}
