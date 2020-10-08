<?php

namespace App\Models\Sistema\Pessoa;

use App\Models\BaseModel;
use App\Models\Sistema\Endereco\Cidade;
use App\Models\Sistema\Pessoa\PesssoaEPessoaRelacao;
use App\Models\Sistema\Pessoa\PessoaTipoContribuinte;

class Pessoa extends BaseModel
{
    protected $fillable = ['ativo',
                            'razaosocial',
                            'idpessoatipo',
                            'codigopesonalizado',
                            'idempresa',
                            'nomefantasia',
                            'cpfoucnpj',
                            'idpessoatipocontribuinte',
                            'iduf',
                            'rgouinscricaoestadual',
                            'rgorgaoemissor',
                            'idpessoasexo',
                            'datanascimentoouabertura',
                            'site',
                            'telefone',
                            'celular',
                            'idempresa',
                            'fax',
                            'placa',
                            'ignoralimitecredito',
                            'limitecredito',
                            'endereco',
                            'numero',
                            'cep',
                            'complemento',
                            'pontoreferencia',
                            'nomecontato',
                            'idenderecotipo',
                            'iddiadasemana',
                            'bairro',
                            'email',
                            'cidade',
                            'idufdocumento',
                            'idpessoaramoatividade',
                            'idcidade',
                            'observacao'];

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'idcidade');
    }

    public function contribuinteTipo(){
        return $this->belongsTo(PessoaTipoContribuinte::class, 'idpessoatipocontribuinte');
    }

    public function pessoaTipoRelacao(){
        return $this->hasMany(PesssoaEPessoaRelacao::class, 'idpessoa')->select('idpessoarelacao');
    }

    public function validarInserir(){

        return [
            'razaosocial' => 'max:100|required|unique:pessoa,razaosocial',
            'codigopesonalizado' => 'max:20|unique:pessoa,codigopesonalizado',
            'cpfoucnpj' => 'required|max:18|unique:pessoa,cpfoucnpj',
            'nomefantasia' => 'required|max:100',
            'rgorgaoemissor' => 'max:4',
            'relacao' => 'required|min:1',
            'observacao' => 'max:500',
        ];
    }

    public function validarAlterar($id = ''){
        return [
            'razaosocial' => 'max:100|required|unique:pessoa,razaosocial, ' . $id,
            'codigopesonalizado' => 'max:20|unique:pessoa,codigopesonalizado, ' . $id,
            'cpfoucnpj' => 'required|max:18|unique:pessoa,cpfoucnpj, ' . $id,
            'nomefantasia' => 'required|max:100',
            'rgorgaoemissor' => 'max:4',
            'relacao' => 'required|min:1',
            'observacao' => 'max:500',
        ];
    }

    public function validarAlias(){
        return [
            'razaosocial' => 'Razao social',
            'nomefantasia' => 'Nome fantasia',
            'cpfoucnpj' => 'CPF ou CNPJ',
            'rgorgaoemissor' => 'RG orgao emissor',
            'relacao' => 'Relacoes',
            'iduf' => 'UF',
            'codigopesonalizado' => 'Codigo pesonalizado',
            'consumidorfinal' => '[consumidor final] está habilitado, sendo assim não é possivel alterar o registro',
            'observacao' => 'Observação'
        ];
    }

    public function validarAntesDeAlterar(){
        return [
            'consumidorfinal' => 'not_in:1'
        ];
    }

    public function isPessoaJuridica(){
        return $this->attributes['idpessoatipo'] == 2;
    }
}
