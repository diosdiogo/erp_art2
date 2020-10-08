<?php

namespace App\Repositorio\Sistema\Financeiro\FormaRecebimento;

use App\Repositorio\BaseRepository;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItem;

class RepositorioDeFinanceiroFormaRecebimento extends BaseRepository
{
    private $chaveRelacao = "formarecebimentoitens";
    
    public function __construct()
    {
        parent::__construct(FinanceiroFormaRecebimento::class);
    }

    public function obterParaAlterar($id){
        $financeiroRecebimento = $this->model->findOrFail($id);
        $financeiroRecebimento[$this->chaveRelacao] = $financeiroRecebimento->formarecebimentoitens->toArray();

        return $financeiroRecebimento;
    }

     public function corrigirRelacionamentoInserir($model, $viewModel){  
        $relacoes = $viewModel[$this->chaveRelacao];

        foreach($relacoes as $relacao){
            $itemInserir = FinanceiroFormaRecebimentoItem::obterModelDados(new FinanceiroFormaRecebimentoItem($relacao), $relacao);
            $model->formarecebimentoitens()->save($itemInserir);
        }
    }

    public function corrigirRelacionamentoAlterar($model, $viewModel){   
        $formasRecebimento = collect($viewModel->get($this->chaveRelacao));
        $formasRecebimentoInseridas = $model[$this->chaveRelacao]->toArray();
        
        $idsInseridos = $this->ObterIds($formasRecebimentoInseridas);
        $idsViewModel = $this->ObterIds($formasRecebimento);

        $remover = array_diff($idsInseridos, $idsViewModel);

        foreach($remover as $id)
            FinanceiroFormaRecebimentoItem::destroy($id);

        $formasRecebimento->each(function ($item) use(&$model, &$idsInseridos){
            $existeId = in_array($item['id'], $idsInseridos);
            if($existeId){
                $modelItem = new FinanceiroFormaRecebimentoItem();
                $expressao = "idformarecebimento =" . $model['id'] . ' AND id=' .$item['id'];
                $entidade = FinanceiroFormaRecebimentoItem::whereRaw($expressao)->first();
                $modelItem->alterar($entidade, $item);
            }
            else{
                 $item['idformarecebimento'] = $model->id;
                 FinanceiroFormaRecebimentoItem::inserir( $item);
            }
        });
    }

    public function obterParaContasReceberDiaPrimeiraParcela($id, $idFormaRecebimento){
        return FinanceiroFormaRecebimentoItem::
        select('financeiroformarecebimentoitem.diaprimeiraparcela')
        ->whereRaw("financeiroformarecebimentoitem.id =" . $id . " AND financeiroformarecebimentoitem.idformarecebimento=" . $idFormaRecebimento)
        ->first()->toArray()['diaprimeiraparcela'];
    }
}