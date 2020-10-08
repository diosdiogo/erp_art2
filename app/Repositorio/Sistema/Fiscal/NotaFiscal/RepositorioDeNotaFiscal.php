<?php

namespace App\Repositorio\Sistema\Fiscal\NotaFiscal;

use DB;
use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use App\ViewModel\Sistema\Behavior\ParametrosGrid;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscal;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscalItem;

class RepositorioDeNotaFiscal extends BaseRepository
{
    private $chaveRelacao = "notafiscalitens";

    public function __construct()
    {
        parent::__construct(NotaFiscal::class);
    }

    public function obterParaAlterar($id){
        $notaFiscal = $this->model->findOrFail($id);
        $pessoa = $notaFiscal->Pessoa;
        $notaFiscal['descricaoPessoa'] = CommonExtension::adicionarCodigoEDescricao($pessoa, "codigopesonalizado","nomefantasia");
        $naturezaOperacao = $notaFiscal->NaturezaOperacao;
        $notaFiscal['descricaoNaturezaOperacao'] = CommonExtension::adicionarCodigoEDescricao($naturezaOperacao);
        $cidade = $pessoa->Cidade;
        $notaFiscal['cidadeDescricao'] = CommonExtension::adicionarCodigoEDescricao($cidade, "codigo");

        $notaFiscalItens = collect($notaFiscal->notaFiscalItens);
        $notaFiscalItens->each(function ($item, $key) use (&$notaFiscal) {
            $produto = $item->produto;
            $notaFiscal[$this->chaveRelacao][$key]['descricao'] =  CommonExtension::adicionarCodigoEDescricao($produto);

            $cst = $item->idcsticms > 0 ? $item->cstICMS : $produto->cstICMS;
            $cfop = $item->idcfop > 0 ? $item->Cfop : $produto->Cfop;
            $notaFiscal[$this->chaveRelacao][$key]['CST'] =  $cst != null ? $cst->codigo : "00";
            $notaFiscal[$this->chaveRelacao][$key]['CFOP'] =  $item->idcfop;
            $notaFiscal[$this->chaveRelacao][$key]['descricaocsticms'] = CommonExtension::adicionarCodigoEDescricao($cst, "codigo");
            $notaFiscal[$this->chaveRelacao][$key]['descricaocfop'] = CommonExtension::adicionarCodigoEDescricao($cfop);
        });

        $notaFiscal->valortotal = CommonExtension::formatarParaMoedaDecimal($notaFiscalItens->sum('valortotalitem'));
        $notaFiscal->valorfrete = CommonExtension::formatarParaMoedaDecimal($notaFiscalItens->sum('valorfrete'));
        $notaFiscal->valorseguro = CommonExtension::formatarParaMoedaDecimal($notaFiscalItens->sum('valorseguro'));
        $notaFiscal->valordesconto = CommonExtension::formatarParaMoedaDecimal($notaFiscalItens->sum('valordesconto'));
        $notaFiscal->valoroutras = CommonExtension::formatarParaMoedaDecimal($notaFiscalItens->sum('valoroutro'));
        return $notaFiscal;
    }

    public function obterGrid(ParametrosGrid $parametrosGrid){
        $parametrosGrid->pPadrao("notafiscal");

        return $this->model
        ->select(
            'notafiscal.id',
            DB::raw("DATE_FORMAT(notafiscal.dataemissao,'%d/%m/%Y') AS dataemissao"),
            'notafiscal.valortotal',
            'notafiscal.NUMERONF',
            'notafiscal.idnotafiscalsituacao',
            DB::raw("COALESCE(notafiscal.numerodocumentoorigem, '000000') as numerodocumentoorigem"),
            DB::raw("COALESCE(notafiscal.motivoretorno, '') as motivoretorno"),
            DB::raw("notafiscalsituacao.descricao as situacao"),
            DB::raw('pessoa.razaosocial as descricaoPessoa'))
        ->leftJoin("pessoa", "pessoa.id", '=', 'notafiscal.idpessoa')
        ->leftJoin("notafiscalsituacao", "notafiscalsituacao.id", '=', 'notafiscal.idnotafiscalsituacao')
        ->whereRaw($parametrosGrid->expressao)
        ->get();
    }


    public function corrigirRelacionamentoInserir($model, $viewModel){
        $this->corrigirInserirItem($model, $viewModel);
    }

    public function corrigirRelacionamentoAlterar($model, $viewModel){
       $this->corrigirAlterarItem($model, $viewModel);
    }

    public function corrigirInserirItem($model, $viewModel){
          try {
            $relacoes = $viewModel[$this->chaveRelacao];
            foreach($relacoes as $relacao){
                $relacao = array_merge ($relacao, array(
                    'idnotafiscal' => $relacoes[0]['id']
                ));

                $itemInserir = NotaFiscalItem::obterModelDados(new NotaFiscalItem($relacao), $relacao);
                $model->notaFiscalItens()->save($itemInserir);
            }
        }catch(Exception $e){
            dd($e);
        }
    }

    private function corrigirAlterarItem($model, $viewModel){
        $notaFiscal = collect($viewModel->get($this->chaveRelacao));
        $notaFiscalInseridas = $model[$this->chaveRelacao]->toArray();
        $idsInseridos = $this->ObterIds($notaFiscalInseridas);
        $idsViewModel = $this->ObterIds($notaFiscal);

        $remover = array_diff($idsInseridos, $idsViewModel);

        foreach($remover as $id)
            NotaFiscalItem::destroy($id);

        $notaFiscal->each(function ($item) use(&$model, &$idsInseridos){
            $existeId = in_array($item['id'], $idsInseridos);
            if($existeId){
                $modelItem = new NotaFiscalItem();
                $expressao = "idnotafiscal =" . $model['id'] . ' AND id=' .$item['id']. ' AND item=' .$item['item'] ;
                $entidade = NotaFiscalItem::whereRaw($expressao)->first();
                $modelItem->alterar($entidade, $item);
            }
            else{
                 $item['idnotafiscal'] = $model->id;
                 NotaFiscalItem::inserir( $item);
            }
        });
    }

}