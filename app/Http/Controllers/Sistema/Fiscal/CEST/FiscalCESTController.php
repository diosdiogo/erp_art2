<?php
namespace App\Http\Controllers\Sistema\Fiscal\CEST;

use App\Http\Controllers\Behavior\GridUpdateBaseController;

class FiscalCESTController extends GridUpdateBaseController
{
    protected $pasta = "fiscal\\CEST";
    protected $inserir = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function obterFiltros(){
        return array("1" => "CEST", "2" => "DESCRIÇÃO");
    }

}