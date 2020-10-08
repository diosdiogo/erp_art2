<?php
namespace App\Http\Controllers\Sistema\Financeiro\Conta;
use \App\Models\Sistema\Financeiro\Conta;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;
use App\Models\Sistema\Financeiro\Banco\FinanceiroBanco;
use Input;
class FinanceiroContaController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "financeiro\\conta";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObterfinanceiroconta(Request $request){
        $bancos = $this->obterDropDownList(FinanceiroBanco::class, $request);
        return $bancos;
    }
}