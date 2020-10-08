<?php

namespace App\Helper;

use Session;
use Exception;
use App\Extension\MapperExtension;
use App\Helper\Sessao\HelperDeSessao;
use App\Enums\EmpresaRamoAtividadeEnum;
use App\Models\Sistema\Empresa\Empresa;
use App\Enums\Sessao\SessaoControllerEnum;
class SessionProperties
{
    public function obterChaveUnica($chave){
       return HelperDeSessao::chaveUnica($chave);
    }

    public function obterEmpresa(){
       return $this->obterParaSessao(SessaoControllerEnum::Empresa, Empresa::class);
    }

    public static function obterIdUsuario(){
        return Session::get(SessaoControllerEnum::IdUsuario);
    }

    private function obterSessionUnica($chave){
        return HelperDeSessao::get($chave);
    }

    public function obterEmpresaFilial(){
        return HelperDeSessao::obterEmpresaFilial();
    }

    public function obterIdFilial(){
        return $this->obterEmpresaFilial()->id;
    }

    public function isEmpresaFrigorifico(){
        return 2 == EmpresaRamoAtividadeEnum::ACOUGUE;
    }

    public function isEmpresaMateriasConstrucao(){
        return 2 == EmpresaRamoAtividadeEnum::MATERIASDECONSTRUCAO;
    }

    private function obterParaSessao($chave, $class){
        $retorno = $this->obterSessionUnica($chave);
        if($retorno == null){
            HelperDeSessao::put($chave, $class::get());
            return $this->obterParaSessao($chave, $class);
        }

        return $retorno;
    }

    public function obterEmpresaBasico($idEmpresa = '1'){
        $empresas = $this->obterEmpresa();
        $retorno = null; //$empresas->first(function ($value, $key) use(&$idEmpresa) { return $key['id'] == $idEmpresa; });
        
        if ($retorno == null) {
            $empresa = Empresa::where('id', $idEmpresa)->first();
            $empresa->cidadeModel = $empresa->Cidade;
            $empresa->estadoModel = $empresa->Cidade->Estado;
            $retorno = $empresa;
        }

        $retorno = $retorno->toArray();

        if(count($retorno) == 1)
            return $retorno[0];
        
        return $retorno;
    }
}