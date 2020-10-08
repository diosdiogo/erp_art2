<?php

namespace App\ViewModel\Sistema\Pessoa;

use App\Models\Sistema\Endereco\UF;
use App\Models\Sistema\Pessoa\PessoaTipo;
use App\Models\Sistema\Pessoa\PessoaSexo;
use App\Models\Sistema\Pessoa\PessoaRelacao;
use App\Models\Sistema\DiaSemana\DiaDaSemana;
use App\Models\Sistema\Endereco\EnderecoTipo;
use App\Models\Sistema\Pessoa\PesssoaEPessoaRelacao;
use App\Models\Sistema\Pessoa\PessoaTipoContribuinte;
use App\Models\Sistema\Pessoa\RamoAtividade\PessoaRamoAtividade;

class UpdatePessoaViewModel
{
    public function inserir(){
        return array(
            'id' => '0',
            'ativo' => 'true',
            'razaosocial' => '',
            'idpessoatipo' => '',
            'nomefantasia' => '',
            'cpfoucnpj' => '',
            'idpessoatipocontribuinte' => '',
            'iduf' => '26',
            'rgouinscricaoestadual' => '',
            'rgorgaoemissor' => '',
            'idpessoasexo' => '',
            'datanascimentoouabertura' => '',
            'site' => '',
            'telefone' => '',
            'celular' => '',
            'fax' => '',
            'placa' => '',
            'ignoralimitecredito' => '',
            'limitecredito' => '',
            'pessoasexos' => PessoaSexo::get(),
            'UFs' => UF::get(),
            'pessoaTipoContribuintes' => PessoaTipoContribuinte::get(),
            'pessoaTipos' => PessoaTipo::get(),
            'pessoaRelacoes' => PessoaRelacao::get(),
            'enderecotipos' => EnderecoTipo::get(),
            'diasdasemana' => DiaDaSemana::get(),
            'at_update' => date("d/m/Y"),
            'at_create' => date("d/m/Y"),
            'relacao' => array(),
            'cep' => '',
            'nomecontato' => '',
            'endereco' => '',
            'bairro' => '',
            'cidade' => '',
            'numero' => '',
            'complemento' => '',
            'pontoreferencia' => '',
            'idenderecotipo' => '',
            'codigopesonalizado' => '',
            'iddiadasemana' => 0,
            'email' => '',
            'idpessoaramoatividade' => '0',
            'idufdocumento' => '',
            'pessoaramoatividades' => PessoaRamoAtividade::get(),
            'idcidade' => '',
            'cidadeDescricao' => '',
            'observacao' => '',
        );
    }
}