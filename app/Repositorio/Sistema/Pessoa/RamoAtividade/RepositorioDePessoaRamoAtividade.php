<?php

namespace App\Repositorio\Sistema\Pessoa\RamoAtividade;

use App\Repositorio\BaseRepository;
use App\Models\Sistema\Pessoa\RamoAtividade\PessoaRamoAtividade;

class RepositorioDePessoaRamoAtividade extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(PessoaRamoAtividade::class);
    }
}