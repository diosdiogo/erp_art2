<?php
namespace App\Http\Controllers\Sistema\Fiscal\NaturezaOperacao;

use Illuminate\Http\Request;
use App\Models\Sistema\Fiscal\CFOP\FiscalCFOP;
use App\Http\Controllers\Behavior\GridUpdateBaseController;

class FiscalNaturezaOperacaoController extends GridUpdateBaseController
{
    protected $pasta = "fiscal\\NaturezaOperacao";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getObtercfop(Request $request){
        return $this->obterDropDownListDinamico(FiscalCFOP::class, $request, "id");
    }
}