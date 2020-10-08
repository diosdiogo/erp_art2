<?php

namespace App\Repositorio\Sistema\Produto;

use DB;
use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use App\Models\Sistema\Produto\Produto;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;

class RepositorioDeProduto extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Produto::class);
    }

    
    public function obterGrid(ParametrosGrid $request){
        return $this->model
        ->select(
            'produto.id',
            'produto.ativo',
            DB::raw('(CASE WHEN ISNULL(produto.codigoreduzido) THEN "*" ELSE produto.codigoreduzido END) AS codigoreduzido'),
            'produto.descricao',
            'produto.preco')
        ->whereRaw($request->expressao)
        ->get();
    }

    public function obterParaAlterar($id){
        $produto = $this->obter($id);

        $ncm = $produto->fiscalNCM;
        $produto['ncmdescricaobanco'] = CommonExtension::adicionarCodigoEDescricao($ncm, "codigo"); 

        $cest = $produto->FiscalCEST;
        $produto['cestdescricaobanco'] = CommonExtension::adicionarCodigoEDescricao($cest, "codigo");

        $fornecedor = $produto->PessoaFornecedor;
        $produto['descricaopessoafornecedor'] = CommonExtension::adicionarCodigoEDescricao($fornecedor, "id", "razaosocial");

        return $produto;
    }
}