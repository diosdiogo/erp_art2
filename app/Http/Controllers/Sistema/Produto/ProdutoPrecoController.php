<?php

namespace App\Http\Controllers\Sistema\Produto;

use DB;
use Session;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Constants\Produto\ProdutoConstans;
use App\Helper\Controller\HelperDropDownList;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Http\Controllers\Behavior\GridBaseController;

class ProdutoPrecoController extends GridBaseController
{
    protected $pasta = "produto";
    protected $nomeModel = "Produto";
    protected $rotaAcao = "produto";
    protected $gridView = "produtopreco";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObterpessoa(Request $request){
        $bancos = HelperDropDownList::obterDinamico(Pessoa::class, $request, 'id', 'razaosocial');
        return $bancos;
    }

    protected function obterFiltros(){
        return array(ProdutoConstans::codigo => "Código", ProdutoConstans::descricao => "Descrição", ProdutoConstans::codigoReduzido => "Código reduzido");
    }

    public function getObtergrid($id = "", ParametrosGrid $request){
        $where = str_replace("idempresa", "produto.idempresa", $request->expressao);

        return DB::connection(Session::get('usuario_banco'))->select(@"SELECT DISTINCT(produto.id), produto.descricao, pessoa.razaosocial,vendaitem.valorunitario as preco, produto.codigoreduzido FROM produto
            LEFT JOIN vendaitem ON produto.id = vendaitem.idproduto
        LEFT JOIN venda ON vendaitem.idvenda = venda.id
            LEFT JOIN pessoa ON pessoa.id = venda.idpessoa WHERE $where AND vendaitem.valorunitario > 0 GROUP BY id, pessoa.id ORDER BY venda.datavenda, pessoa.razaosocial DESC");

    }

    public function getObtergridpesquisa(ParametrosGrid $request){
        $parametro = $request->obterParametro();
        $idPessoa = $request->obterIdDropDrownList();

        switch ($request->obterIdFiltro()) {
                case ProdutoConstans::codigo:
                    if($parametro > 0)
                        $request->pAnd('produto.id', $parametro);
                    break;
                case ProdutoConstans::descricao:
                        $request->pAndLike('descricao', $parametro);
                    break;
                case ProdutoConstans::codigoReduzido:
                        $request->pAndLike('codigoreduzido', $parametro);
                    break;
                default:
                    break;
            }
            if($idPessoa > 0){
                $request->pAnd('venda.idpessoa', $idPessoa);
            }

        return $this->getObtergrid($request->obterId(), $request);
    }
}