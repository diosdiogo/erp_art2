<?php

namespace App\Http\Controllers\Sistema\Documentacao;


use Illuminate\Http\Request;
use App\Http\Controllers\Behavior\BaseAuthController;

use App\Http\Requests;

class DocumentacaoController extends BaseAuthController
{
    protected $pasta = "documentacao";
    protected $inicializarModel = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }

    public function getIndex(){
        return view("$this->pasta/updatedocumentacao", $this->obterParametrosPadroesBase());
    }
}
