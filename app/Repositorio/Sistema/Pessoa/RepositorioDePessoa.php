<?php

namespace App\Repositorio\Sistema\Pessoa;

use DB;
use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use App\Models\Sistema\Pessoa\Pessoa;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Models\Sistema\Pessoa\PesssoaEPessoaRelacao;

class RepositorioDePessoa extends BaseRepository
{
    private $chaveRelacao = "relacao";
    private $chaveLigacao = "idpessoarelacao";

    public function __construct()
    {
        parent::__construct(Pessoa::class);
    }

    public function obterParaAlterar($id){
        $pessoa = $this->obter($id);
        $pessoa[$this->chaveRelacao] = $this->toArrayView($pessoa['pessoaTipoRelacao']->toArray());
        $cidade = $pessoa->Cidade;
        $pessoa['cidadeDescricao'] = CommonExtension::adicionarCodigoEDescricao($cidade, "codigo");
        return $pessoa;
    }

    public function obterEndereco($id){
        return $this->db->select(DB::raw(@"SELECT 
                        endereco,
                        numero,
                        complemento,
                        bairro,
                        idcidade,
                        pontoreferencia,
                        iduf,
                        cep,
                        idenderecotipo,
                        UCASE((SELECT CONCAT(id, ' - ',descricao) FROM sistema.cidade WHERE id = idcidade)) as cidadeDescricao
                    FROM pessoa
                        WHERE id = $id"));
    }
    
    public function obterGrid(ParametrosGrid $request){
        return $this->model
        ->select(
            'pessoa.id',
            'pessoa.razaosocial',
            'pessoa.idpessoatipo',
            'pessoa.cpfoucnpj',
            DB::raw('(CASE WHEN ISNULL(pessoa.codigopesonalizado) THEN "SEM CÓDIGO" ELSE pessoa.codigopesonalizado END) AS codigopesonalizado'),
            DB::raw('(CASE WHEN ISNULL('. "CONCAT('[',GROUP_CONCAT(sistema.pessoarelacao.descricao SEPARATOR '] ['),']')" .') THEN "CLIENTE - CONSUMIDOR FINAL" ELSE ' . "CONCAT('',GROUP_CONCAT(sistema.pessoarelacao.descricao SEPARATOR '.'),'') END)".' AS descricao'),
            'sistema.pessoatipo.descricao as pessoatipo')
        ->leftJoin("pessoaepessoarelacao", "pessoa.id", '=', 'pessoaepessoarelacao.idpessoa')
        ->leftJoin("sistema.pessoarelacao", "pessoaepessoarelacao.idpessoarelacao", '=', 'sistema.pessoarelacao.id')
        ->leftJoin("sistema.pessoatipo", "pessoa.idpessoatipo", '=', 'sistema.pessoatipo.id')
        ->groupBy('pessoa.id')
        ->whereRaw($request->expressao)
        ->get();
    }

    public function corrigirRelacionamentoInserir($model, $viewModel){   
        $relacoes = $viewModel->get($this->chaveRelacao);
        if($relacoes != null){
            foreach($relacoes as $relacao){
                $parametros = array($this->chaveLigacao => $relacao);
                $model->pessoaTipoRelacao()->save(PesssoaEPessoaRelacao::obterModelDados(new PesssoaEPessoaRelacao($parametros), $parametros));
            }
        }
    }

    public function corrigirRelacionamentoAlterar($model, $viewModel){   
        $relacoes = $viewModel->get($this->chaveRelacao);

        $modelRelacao = $this->toArrayView($model['pessoaTipoRelacao']->toArray());
        $diferenca = array_diff($relacoes, $modelRelacao);

        foreach($diferenca as $relacao){
            $parametros = array($this->chaveLigacao => $relacao);
            $model->pessoaTipoRelacao()->save(PesssoaEPessoaRelacao::obterModelDados(new PesssoaEPessoaRelacao($parametros), $parametros));
        }

        $remover = array_diff($modelRelacao, $relacoes);

        foreach($remover as $relacao){
            $id = PesssoaEPessoaRelacao::select("id")->where("idpessoa", $model->id)->where($this->chaveLigacao, $relacao)->first();
            PesssoaEPessoaRelacao::destroy($id->toArray()["id"]);
        }
    }
}