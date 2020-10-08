<?php

namespace App\Servico\Sistema\Venda;

use App\Extension\CommonExtension;
use App\Models\Sistema\Venda\Venda;

class ServicoDeVenda
{
    protected $viewModel;
    protected $vendaitens = "vendaitens";
    protected $repositorioDeVenda;

    public function __construct($viewModel)
    {
        $this->viewModel = $viewModel;
    }

    public function obterVendaItens(){
        return $this->viewModel->get($this->vendaitens);
    }

    public function obterItens(){
        return collect($this->obterVendaItens())->values()->toArray();
    }

    public function obterValores(){
        $itens = collect($this->obterVendaItens());
        $valorTotal = $itens->sum('valortotal');
        $descontomoeda = $itens->sum('descontomoeda');
        $acrescimomoeda = $itens->sum('acrescimomoeda');

        return array(
            'valortotal' => CommonExtension::removerVirgulaPorPonto($valorTotal),
            'quantidadeItens' => CommonExtension::removerVirgulaPorPonto($itens->count()),
            'valortotalpagar' => CommonExtension::removerVirgulaPorPonto($itens->sum('valortotal')),
            'descontomoeda' => CommonExtension::removerVirgulaPorPonto($itens->sum('descontomoeda')),
            'acrescimomoeda' => CommonExtension::removerVirgulaPorPonto($itens->sum('acrescimomoeda')),
        );
    }

    public function obterValorTotalVenda(){
        return str_replace(",", "." , collect($this->obterVendaItens())->sum('valortotal'));
    }

    public function validarValorRecebido(&$viewModel){
        $viewModel['valorTotalJaRecebido'] = str_replace(",", ".", $viewModel['diferencia']) == 0 ? 1 : 0;
    }

    public function gerarNotaFiscal($idVenda){
        $venda = Venda::where('id', $idVenda)->get()[0];
        $itens = $venda->Vendaitens;
        $pessoa = $venda->Pessoa;

        return array(
            'idpessoa' => $venda->idpessoa,
            'descricaoPessoa' => CommonExtension::codigoEDescricaoPessoa($pessoa),
            'numerodocumentoorigem' => $venda->id,
            'valortotal' => $venda->valortotal,
            'notafiscalitens' => $this->obterItensParaNotaFiscal($itens),
            'origemvenda' => true
            //$venda
        );
    }

    private function obterItensParaNotaFiscal($itens){
        $produtos = array();
        $itens->each(function ($item, $key) use(&$produtos) {
            $produto = $item->Produto;
            $unidadeMedida = $produto->UnidadeMedida;
            $cstICMS = $produto->cstICMS;

            $produtos[$key] = array(
                'id' => $item->id,
                'descricao' => ($produto->id == 1 ? $item->produtonomegenerico : CommonExtension::adicionarCodigoEDescricao($produto)),
                'produtonomegenerico' => $item->produtonomegenerico,
                'unidademedidacomercial' => strtoupper($unidadeMedida->descricaoreduzida),
                'quantidade' => $item->quantidade,
                'valorunitario' => $item->valorunitario,
                'valordesconto' => $item->descontomoeda,
                'CST' => $cstICMS != null ? $cstICMS->codigo : "",
                'CFOP' => $produto->idcfop,
                'valortotalitem' => $item->valortotal,
                'item' => $key+1,
                'idproduto' => $item->idproduto,
                'idcfop' => $produto->idcfop,
                'idcsticms' => $produto->idcsticms
                //'idcest' => $produto->idfiscalcest,
                // 'ordem' => $key+1,
                // 'idvenda' => $item->idvenda,
                // 'acrescimomoeda' => $item->acrescimomoeda,
                // 'descontomoeda' => $item->descontomoeda,
                // 'idcst' => '1',
                // 'descontoporcentagem' => $item->descontoporcentagem,
                // 'quantidadequadrado' => $item->quantidadequadrado,
                // 'idunidademedida' => $produto->idunidademedida,
                // 'quantidadequadradotexto' => $item->quantidadequadradotexto,
                // 'altura' => $item->altura,
                // 'largura' => $item->largura,
            );
        });

        return $produtos;
    }
}