<?php
namespace App\Http\Controllers\Sistema\Fiscal\CFOP;

use App\Http\Controllers\Behavior\GridUpdateBaseController;

class FiscalCFOPController extends GridUpdateBaseController
{
    protected $pasta = "fiscal\\CFOP";
    protected $inserir = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function obterFiltros(){
        return array("1" => "CÓDIGO", "2" => "DESCRIÇÃO");
    }

}