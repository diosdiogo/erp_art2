<?php
namespace App\Helper\Sessao;

use Session;
use App\Enums\Sessao\SessaoControllerEnum;

class HelperDeSessao
{
    public static function obterIdUsuario(){
        return Session::get(SessaoControllerEnum::IdUsuario);
    } 

    public static function obterEmpresaFilial(){
        return Session::get(SessaoControllerEnum::EmpresaFilial . HelperDeSessao::obterIdUsuario());
    }

   // Manter o nomes padrões apenas para não confundir
    public static function chaveUnica($chaveSessao){
        $empresaFilial = HelperDeSessao::obterEmpresaFilial();
        if($empresaFilial != null){
            $banco = HelperDeSessao::obterEmpresaFilial()->banco;
            return $chaveSessao . HelperDeSessao::obterIdUsuario() . "_" . $banco;
        }
    }

    public static function get($chave){
        return Session::get(HelperDeSessao::chaveUnica($chave));
    }

    public static function put($chave, $valor){
        return Session::put(HelperDeSessao::chaveUnica($chave), $valor);
    }

    public static function has($chave){
        return Session::has(HelperDeSessao::chaveUnica($chave));
    }
}