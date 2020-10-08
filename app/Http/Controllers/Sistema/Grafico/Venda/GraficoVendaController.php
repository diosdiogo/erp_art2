<?php

namespace App\Http\Controllers\Sistema\Grafico\Venda;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Sistema\Venda\Venda;
use App\Repositorio\Sistema\Venda\RepositorioDeVenda;
use App\Http\Controllers\Behavior\UpdateBaseDashboardController;

class GraficoVendaController extends UpdateBaseDashboardController
{
    protected $pasta = "grafico\\venda";
    protected $gridView = "grafico.venda.updategraficovenda";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function obterParametrosPadraoExtra(){
        $repositorioDeVenda = new RepositorioDeVenda();
        
        return array(
            'graficoProdutoQuantidade' => $this->formatarParaGrafico($repositorioDeVenda->obterParaDashVenda()->toArray()),
            'graficoVendaAnual' => utf8_encode(json_encode($repositorioDeVenda->obterParaDashVendaAnual()))
        );
    }

    protected function formatarParaGrafico($lista = array()){
        $colecao = collect($lista);
        $colecao->each(function ($item, $key) use(&$retorno) {
            $retorno[] = [$item['quantidade'] => $item['descricao']];
        });
        
        return json_encode($retorno);
    }
}
