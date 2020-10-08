<?php
namespace App\Http\Controllers\Sistema\Financeiro\Banco;
use \App\Models\Sistema\Financeiro\Banco;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;

class FinanceiroBancoController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "financeiro\\banco";
    protected $inserir = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}