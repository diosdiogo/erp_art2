<?php

namespace App\Repositorio\Sistema\Venda;

use DB;
use Session;
use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use App\Models\Sistema\Venda\Venda;
use App\Models\Sistema\Venda\VendaItem;
use App\Models\Sistema\Produto\Produto;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Models\Sistema\Venda\VendaFormaRecebimentoParcela;

class RepositorioDeVenda extends BaseRepository
{
    private $chaveRelacao = "vendaitens";
    private $chaveRelacaoParcela = "parcelaitens";

    public function __construct()
    {
        parent::__construct(Venda::class);
    }

    public function obterParaAlterar($id){
        $venda = $this->model->findOrFail($id);
        $vendaItens = collect($venda->vendaitens);
        $venda[$this->chaveRelacaoParcela] = $venda->parcelaitens;
        $pessoa = $venda->Pessoa;
        $venda['nomepessoa'] = CommonExtension::adicionarCodigoEDescricao($pessoa, "id", "razaosocial");
        $venda['pessoa'] =  $pessoa->toArray();
        $formaRecebimento = $venda->FormaRecebimento;
        $venda['valortotalparcela'] = collect($venda[$this->chaveRelacaoParcela])->sum('valor') * 100;
        $venda['diferencia'] = 0;
        $venda['formarecebimentodescricao'] = CommonExtension::adicionarCodigoEDescricao($formaRecebimento);

        if($venda->parcelaitens->count()){
            $venda->parcelaitens->each(function ($item, $key) use (&$venda) {
                $financeiroTipo = $item->financeiroTipo;
                $venda[$this->chaveRelacaoParcela][$key]['financeirotipodescricao'] = CommonExtension::adicionarCodigoEDescricao($financeiroTipo);
            });

            $ultimaParcela = $venda->parcelaitens->last();
            $ultimaParcela->valor += number_format(round((float)($venda['valortotal'] - collect($venda[$this->chaveRelacaoParcela])->sum('valor')),2),2);
        }

        $vendaItens->each(function ($item, $key) use (&$venda) {
            $produto = $item->produto;
            $venda[$this->chaveRelacao][$key]['descricao'] = ($produto->id . ' - ' . strtoupper($produto->descricao));
        });

        return $venda;
    }

    public function obterImpressaoRomaneios($viewModel){
        $whereTransportadora = "";
        if($viewModel['idtransportadora'] > 0){
            $whereTransportadora .= (" venda.idtransportadora=" . $viewModel['idtransportadora'] . " AND ");
        }

        $sql = @"SELECT
                        RIGHT(CONCAT('000000', produto.id), 6) as idproduto,
                    produto.codigoreduzido,produto.descricao,
                        sum(vendaitem.quantidadepeca) as quantidade,
                    unidademedida.descricaoreduzida as unidade,
                    unidademedida.id as idunidademedida,
                        transportadora.descricao as descricaotransportadora,
                    venda.id as idvenda,
                        venda.idpessoa as idcliente
                FROM venda
                        LEFT JOIN vendaitem
                ON venda.id = vendaitem.idvenda
                        LEFT JOIN produto
                ON produto.id = vendaitem.idproduto
                        LEFT JOIN transportadora
                ON transportadora.id = venda.idtransportadora
                        LEFT JOIN unidademedida
                ON unidademedida.id = produto.idunidademedida
                WHERE $whereTransportadora venda.datavenda BETWEEN '". $viewModel['dataInicial'] ."'  AND '". $viewModel['dataFinal'] ."'
                GROUP BY produto.id";

        return $this->db->select(DB::raw($sql));
    }

    public function obterParaImprimir($id){
        $venda = $this->model->findOrFail($id);
        $vendaItens = collect($venda->vendaitens);
        $venda[$this->chaveRelacaoParcela] = $venda->parcelaitens;
        $pessoa = $venda->Pessoa;
        $venda['nomepessoa'] = CommonExtension::adicionarCodigoEDescricao($pessoa, "id", "razaosocial");
        $venda['pessoa'] =  $pessoa->toArray();

        $idCidade = $venda['pessoa']['idcidade'];
        if($idCidade > 0){
            $cidade =  $pessoa->Cidade;
            $venda['pessoacidade'] = $cidade->descricao;
        }else
            $venda['pessoacidade'] = $venda['pessoa']['cidade'];

        $venda['idtransportadora'] = CommonExtension::stringZero($venda['idtransportadora']);
        $venda['descricaotransportadora'] = CommonExtension::adicionarCodigoEDescricao($venda->transportadora);
        $formaRecebimento = $venda->FormaRecebimento;
        $venda['formarecebimentodescricao'] = 'PARCELAS '. $venda->parcelaitens->count() . 'X';

        $venda->parcelaitens->each(function ($item, $key) use (&$venda) {
            $financeiroTipo = $item->financeiroTipo;

            $venda[$this->chaveRelacaoParcela][$key]['financeirotipodescricao'] = CommonExtension::adicionarCodigoEDescricao($financeiroTipo);
            $venda[$this->chaveRelacaoParcela][$key]['descricao'] =
                '<b>PARCELA:</b> ' . $item['parcela'] . '  <b>TIPO:</b> ' . $venda[$this->chaveRelacaoParcela][$key]['financeirotipodescricao'].
                '  <b>VALOR:</b> R$' . CommonExtension::formatarParaMoedaDecimal($item['valor']) . '  <b>VENCIMENTO:</b> ' .  CommonExtension::formatarData(date_create($item['datavencimento']))
                . '<br>';

                $venda['datavencimento'] = CommonExtension::formatarData(date_create($item['datavencimento']));
        });

        $venda->vendaitens->each(function ($item, $key) use (&$venda) {
            $produto = $item->produto;

            $quadrado = $item['quantidadepeca'];
            $item['quantidadequadradodescricao'] = "";
            if($quadrado > 0 && $item['quantidadequadrado'] > 0){
                $_quantidades = [9, 19, 29, 39, 49, 59, 69, 79, 89, 99, 109, 119, 129, 139, 149, 159, 169, 179, 189, 199];
                for($i = 0; $i < $quadrado; $i++)
                    $item['quantidadequadradodescricao'] .= "[________]" . (in_array($i, $_quantidades) ? '<br>' : '');
            }

            $item['quantidadepeca'] = CommonExtension::formatarParaQuantidade($item['quantidadepeca'] == null ? $item['quantidade'] : $item['quantidadepeca']);
            $item['idproduto'] = CommonExtension::stringZero($produto->id);
            $item['descricao'] = $produto->descricao;
            $item['valorunitario'] = CommonExtension::formatarParaMoeda($venda[$this->chaveRelacao][$key]['valorunitario']);
            $item['valortotal'] = CommonExtension::formatarParaMoeda($venda[$this->chaveRelacao][$key]['valortotal']);
        });

        $venda['valortotal'] = CommonExtension::formatarParaMoeda($venda['valortotal']);

        return $venda;
    }

    public function obterParaImprimirVarios($ids){
        $ids = explode(",", $ids);
        $retorno = collect([]);

        foreach ($ids as $id)
            $retorno[] = $this->obterParaImprimir($id)->toArray();

        return $retorno;
    }

    public function obterValorUnitarioUltimoPedido($request){
        $sql = @"SELECT vendaitem.valorunitario
                    FROM venda
                LEFT JOIN vendaitem
                    ON venda.id = vendaitem.idvenda
                WHERE venda.idpessoa = ". $request['idpessoa'] ."
                    AND vendaitem.idproduto	 = ". $request['idproduto'] ."
                ORDER BY venda.id
                    DESC limit 1";

        return $this->db->select(DB::raw($sql));
    }

    public function obterParaCupomNaoFiscal($id){
        $venda = $this->model->findOrFail($id);
        $vendaItens = collect($venda->vendaitens);
        $venda[$this->chaveRelacaoParcela] = $venda->parcelaitens;
        $pessoa = $venda->Pessoa;
        $venda['nomepessoa'] = CommonExtension::adicionarCodigoEDescricao($pessoa, "id", "razaosocial");
        $venda['pessoa'] =  $pessoa->toArray();

        $vendaItens->each(function ($item, $key) use (&$venda) {
            $produto = $item->produto;
            $venda[$this->chaveRelacao][$key]['descricao'] = ($produto->descricao);
        });

        return $venda;
    }

    public function obterParaDashVenda(){
        return $this->model->select(DB::raw("REPLACE(produto.descricao, '\"', '') as descricao"), DB::raw("COUNT(produto.descricao) as quantidade "))
            ->leftJoin("vendaitem", "vendaitem.idvenda", '=', 'venda.id')
            ->leftJoin("produto", "produto.id", '=', 'vendaitem.idproduto')
            ->groupBy('produto.descricao')
            ->limit(5)
            ->get();
    }

    public function obterParaDashVendaAnual(){
        $ano = date("Y");
        return $this->db->select( DB::raw(@"SELECT mes.descricao, COALESCE(valortotal,0) as valortotal, COALESCE(EXTRACT(year FROM datavenda), $ano) as ano, COALESCE(EXTRACT(MONTH  FROM datavenda), mes.id) as mes FROM mes
                LEFT JOIN ". Session::get('usuario_banco') .".venda ON EXTRACT(MONTH FROM datavenda) = mes.id
                WHERE COALESCE(EXTRACT(year FROM datavenda), $ano) = $ano
                GROUP BY YEAR(". Session::get('usuario_banco') .".venda.datavenda), MONTH(". Session::get('usuario_banco') .".venda.datavenda) , descricao
                ORDER BY mes desc
                LIMIT 12"));
    }

    public function obterGrid(ParametrosGrid $parametros){
        $parametros->pPadrao("venda");

        return $this->model
        ->select(
            'venda.id',
            'venda.valortotal',
            'venda.observacao',
            'venda.idvendasituacao',
            DB::raw("CONCAT(pessoa.id, ' - ', pessoa.nomefantasia) as nomepessoa"),
            DB::raw("vendasituacao.descricao as situacao"),
            'venda.datavenda')
        ->leftJoin("pessoa", "pessoa.id", '=', 'venda.idpessoa')
        ->leftJoin("transportadora", "transportadora.id", '=', 'venda.idtransportadora')
        ->leftJoin("vendasituacao", "vendasituacao.id", '=', 'venda.idvendasituacao')
        ->whereRaw($parametros->expressao)
        ->get();
    }

    public function corrigirRelacionamentoAlterar($model, $viewModel){
       $this->corrigirAlterarItem($model, $viewModel);
       $this->corrigirAlterarParcela($model, $viewModel);
    }

    public function corrigirRelacionamentoInserir($model, $viewModel){
        $this->corrigirInserirItem($model, $viewModel);
        $this->corrigirInserirParcela($model, $viewModel);
    }

    public function corrigirInserirItem($model, $viewModel){
        $relacoes = $viewModel[$this->chaveRelacao];

        foreach($relacoes as $relacao){
            $itemInserir = VendaItem::obterModelDados(new VendaItem($relacao), $relacao);
            $model->vendaitens()->save($itemInserir);
        }
    }

    private function corrigirAlterarItem($model, $viewModel){
        $vendas = collect($viewModel->get($this->chaveRelacao));
        $vendasInseridas = $model[$this->chaveRelacao]->toArray();
        $idsInseridos = $this->ObterIds($vendasInseridas);
        $idsViewModel = $this->ObterIds($vendas);

        $remover = array_diff($idsInseridos, $idsViewModel);

        foreach($remover as $id)
            VendaItem::destroy($id);

        $vendas->each(function ($item) use(&$model, &$idsInseridos){
            $existeId = in_array($item['id'], $idsInseridos);
            if($existeId){
                $modelItem = new VendaItem();
                $expressao = "idvenda =" . $model['id'] . ' AND id=' .$item['id'];
                $entidade = VendaItem::whereRaw($expressao)->first();
                $modelItem->alterar($entidade, $item);
            }
            else{
                 $item['idvenda'] = $model->id;
                 VendaItem::inserir( $item);
            }
        });
    }

    public function corrigirInserirParcela($model, $viewModel){
        $relacoes = $viewModel[$this->chaveRelacaoParcela];

        foreach($relacoes as $relacao){
            $itemInserir = VendaFormaRecebimentoParcela::obterModelDados(new VendaFormaRecebimentoParcela($relacao), $relacao);
            $model->parcelaitens()->save($itemInserir);
        }
    }

    private function corrigirAlterarParcela($model, $viewModel){
        $vendas = collect($viewModel->get($this->chaveRelacaoParcela));

        VendaFormaRecebimentoParcela::whereRaw("idvenda =" . $model['id'])->delete();

        $vendas->each(function ($item) use(&$model){
            $item['idvenda'] = $model->id;
            VendaFormaRecebimentoParcela::inserir( $item);
        });
    }
}