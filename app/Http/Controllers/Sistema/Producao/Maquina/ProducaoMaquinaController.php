<?php
namespace App\Http\Controllers\Sistema\Producao\Maquina;

use App\Http\Controllers\Behavior\GridUpdateBaseController;

class ProducaoMaquinaController extends GridUpdateBaseController
{
    protected $pasta = "producao\\maquina";

    public function __construct()
    {
        parent::__construct($this->pasta);
    }
}