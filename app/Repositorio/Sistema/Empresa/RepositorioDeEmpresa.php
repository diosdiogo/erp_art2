<?php

namespace App\Repositorio\Sistema\Empresa;

use DB;
use App\Behavior\ParametrosGrid;
use App\Extension\CommonExtension;
use App\Repositorio\BaseRepository;
use App\Models\Sistema\Empresa\Empresa;

class RepositorioDeEmpresa extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Empresa::class);
    }

    public function obterParaAlterar($id){
        $empresa = $this->model->findOrFail($id);
        $cidade = $empresa->Cidade;
        $empresa['cidadeDescricao'] = CommonExtension::adicionarCodigoEDescricao($cidade, "codigo");
        $empresa['cnaeDescricao'] = CommonExtension::adicionarCodigoEDescricao($empresa->Cnae, "codigo");

        $cfopDentro = $empresa->fiscalCFOPDentroEstado;
        $empresa['CFOPDentrodescricaobanco'] = CommonExtension::adicionarCodigoEDescricao($cfopDentro);

        $cfopFora = $empresa->fiscalCFOPForaEstado;
        $empresa['CFOPForadescricaobanco'] = CommonExtension::adicionarCodigoEDescricao($cfopFora);
        return $empresa;
    }
}