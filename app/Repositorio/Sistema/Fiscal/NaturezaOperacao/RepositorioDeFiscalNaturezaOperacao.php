<?php

namespace App\Repositorio\Sistema\Fiscal\NaturezaOperacao;

use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use DB;
use App\Models\Sistema\Fiscal\NaturezaOperacao\FiscalNaturezaOperacao;

class RepositorioDeFiscalNaturezaOperacao extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(FiscalNaturezaOperacao::class);
    }

    public function obterParaAlterar($id){
        $naturezaOperacao = $this->obter($id);

        $cfopDentro = $naturezaOperacao->fiscalCFOPDentroEstado;
        $naturezaOperacao['CFOPDentrodescricaobanco'] = CommonExtension::adicionarCodigoEDescricao($cfopDentro); 

        $cfopFora = $naturezaOperacao->fiscalCFOPForaEstado;
        $naturezaOperacao['CFOPForadescricaobanco'] = CommonExtension::adicionarCodigoEDescricao($cfopFora);

        return $naturezaOperacao;
    }
}