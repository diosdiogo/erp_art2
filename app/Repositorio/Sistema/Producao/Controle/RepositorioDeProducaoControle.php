<?php

namespace App\Repositorio\Sistema\Producao\Controle;

use App\Repositorio\BaseRepository;
use App\Extension\CommonExtension;
use App\Models\Sistema\Producao\Controle\ProducaoControle;

class RepositorioDeProducaoControle extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(ProducaoControle::class);
    }

    public function obterParaAlterar($id){
        $producaoControle = $this->obter($id);

        $produto = $producaoControle->Produto;
        $producaoControle['descricaoproduto'] = CommonExtension::adicionarCodigoEDescricao($produto);

        $pessoa = $producaoControle->Pessoa;
        $producaoControle['descricaopessoa'] = CommonExtension::adicionarCodigoEDescricao($pessoa, 'id', 'razaosocial');

        $maquina = $producaoControle->Maquina;
        $producaoControle['descricaoproducaomaquina'] = CommonExtension::adicionarCodigoEDescricao($maquina);

        return $producaoControle;
    }
}