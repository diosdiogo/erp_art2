<?php
namespace App\Http\Controllers\Sistema\Financeiro\FormaRecebimento\Tipo;

use App\Http\Controllers\Behavior\GridUpdateBaseController;

class FinanceiroFormaRecebimentoTipoController extends GridUpdateBaseController
{
    protected $pasta = "financeiro\\FormaRecebimento\\Tipo";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}