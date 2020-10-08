<?php

namespace App\Repositorio\Sistema\Financeiro\Conta;

use App\Repositorio\BaseRepository;
use App\Models\Sistema\Financeiro\Conta\FinanceiroConta;

class RepositorioDeFinanceiroConta extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(FinanceiroConta::class);
    }

    public function obterParaAlterar($id){
        $financeiroConta = $this->obter($id);
        $financeiroConta['descricaobanco'] = $financeiroConta->financeiroBanco['descricao'];
        return $financeiroConta;
    }
}