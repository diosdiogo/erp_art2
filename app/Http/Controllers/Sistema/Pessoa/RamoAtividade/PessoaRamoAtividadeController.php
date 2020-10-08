<?php

namespace App\Http\Controllers\Sistema\Pessoa\RamoAtividade;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Behavior;
use DB;

class PessoaRamoAtividadeController extends Behavior\GridUpdateBaseController
{
    protected $pasta = "pessoa\\RamoAtividade";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}