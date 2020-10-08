<?php
namespace App\Http\Controllers\Sistema\Producao\Controle;

use Illuminate\Http\Request;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Models\Sistema\Produto\Produto;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Producao\Maquina\ProducaoMaquina;

class ProducaoControleController extends GridUpdateBaseController
{
    protected $pasta = "producao\\controle";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObterproduto(Request $request){
        $produtos = $this->obterDropDownListBase(Produto::class, $request);

        return $produtos;
    }

    public function getObterpessoa(Request $request){
        return $this->obterDropDownListDinamico(Pessoa::class, $request, 'id', 'razaosocial');
    }

    public function getObterproducaomaquina(Request $request){
        return $this->obterDropDownListBase(ProducaoMaquina::class, $request);
    }

    protected function eventoDepoisInserir($model){
        $produto = $model->Produto;
        $produto->estoquequantidade += $model->estoquequantidade;
        $produto->save();
    }
}