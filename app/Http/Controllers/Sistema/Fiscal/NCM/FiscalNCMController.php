<?php
namespace App\Http\Controllers\Sistema\Fiscal\NCM;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use DB;

class FiscalNCMController extends GridUpdateBaseController
{
    protected $pasta = "fiscal\\NCM";
    protected $inserir = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    protected function obterFiltros(){
        return array("1" => "NCM", "2" => "DESCRIÇÃO");
    }

}