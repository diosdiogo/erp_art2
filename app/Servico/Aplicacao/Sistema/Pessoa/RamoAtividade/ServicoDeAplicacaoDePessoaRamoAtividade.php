<?php

namespace App\Repositorio\Sistema\Financeiro\FormaRecebimento;

use App\Servico\Aplicacao\BaseApplicationService;
use App\Models\Sistema\Pessoa\RamoAtividade\PessoaRamoAtividade;

class ServicoDeAplicacaoDePessoaRamoAtividade extends BaseApplicationService
{
    public function __construct()
    {
        parent::__construct(PessoaRamoAtividade::class);
    }
}