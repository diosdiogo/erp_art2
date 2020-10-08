<?php

namespace App;

namespace App\Models\Sistema\Notificacao;
use App\Models\BaseModel;
use App\Helper\Sessao\HelperDeSessao;
use App\Enums\Sessao\SessaoControllerEnum;

class Notificacao extends BaseModel
{
    public static function alterarNotificacoesParaLida(){
        Notificacao::where(Notificacao::obterExpressaoParaHome())->update(['lida' => 1]);
        Notificacao::ObterParaHome(true);
    }

    public static function obterParaHome($alterar = false){
        if(!HelperDeSessao::has(SessaoControllerEnum::Notificacao) || $alterar){
            HelperDeSessao::put(SessaoControllerEnum::Notificacao, Notificacao::where(Notificacao::obterExpressaoParaHome())->get());
        }
    }

    private static function obterExpressaoParaHome(){
        return [['lida', '=', 0], ['idusuario', '=', HelperDeSessao::obterIdUsuario()]];
    }
}
