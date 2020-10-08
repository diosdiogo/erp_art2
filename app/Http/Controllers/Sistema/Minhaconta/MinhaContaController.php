<?php

namespace App\Http\Controllers\Sistema\Minhaconta;

use App\Http\Controllers\Behavior;

class MinhaContaController extends Behavior\BaseAuthController
{
    protected $pasta = "minhaconta";
    protected $gridView = "minhaconta.minhaconta";
    protected $inicializarModel = false;

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}
