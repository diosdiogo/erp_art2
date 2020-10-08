<?php

namespace App\Helper\Controller;

use Session;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Produto\Produto;
use App\Extension\MapperExtension;
use App\Enums\Sessao\SessaoControllerEnum;
use App\Models\Sistema\ConfiguracaoPadrao\ConfiguracaoPadrao;
use App\Models\Sistema\Notificacao\Notificacao;
use App\Helper\Sessao\HelperDeSessao;
use App\Repositorio\Sistema\Financeiro\Lancamento\RepositorioDeFinanceiroLancamento;

class HelperDeControllerBase
{
    public static function formatarRota($pasta){
        $rotas = explode("\\", ucfirst("$pasta"));
        $retorno = null;
        $totalDeRotas = count($rotas);
        $contadorDeRotas = 1;
        $url = url(strtolower(implode($rotas)));

        if(count($rotas) > 0){
            foreach ($rotas as $rota){
                $rota = ucfirst($rota);
                if(!$rota)
                    $rota = "Inicio";

                $dividirRotas = preg_split('/(?=[A-Z])/', $rota, NULL, PREG_SPLIT_NO_EMPTY);

                if($dividirRotas > 1){
                    $stringRota = $totalDeRotas == $contadorDeRotas ?  "<a href='". $url  ."'>" . implode(" ", $dividirRotas) . "</a>" : implode(" ", $dividirRotas);
                    $retorno .= "<li class='active'> $stringRota </li>";
                }
                else
                    $retorno .= "<li class='active'> $rota </li>";

                $contadorDeRotas++;
            }
        }

        return $retorno;
    }

     public static function formatarCaminhoPasta($pasta){
        $rotas = explode("\\", ucfirst("$pasta"));
        $retorno = null;
        if(count($rotas) > 0){
            foreach ($rotas as $rota){
                $rota = ucfirst($rota);
                $retorno .= $rota .'\\';
            }
        }

        return substr_replace($retorno, "", -1);
    }

    public static function obterNomeModel($controller){
        return str_replace("Controller", "", $controller);
    }

    public static function obterModel($pasta, $model){
        return "App\\Models\\Sistema\\$pasta\\$model";
    }

    public static function obterNomeController($classe){
        $controllerNome = explode("\\", get_class($classe));
        return $controllerNome[count($controllerNome) - 1];
    }

    public static function obterRota($rota, $rotaAdicional){
        if($rotaAdicional)
            $rota = "$rota <li class='active'>". ucfirst($rotaAdicional) ."</li>";

        return $rota;
    }

    public static function obterParametroHome(){
        $repositorioDeFinanceiroLancamento = new RepositorioDeFinanceiroLancamento();
        return array(
                        'quantidadePessoa' => Pessoa::where('ativo', '1')->count(),
                        'quantidadeProduto' => Produto::where('ativo', '1')->count(),
                        'dashboardMovimentacao' => $repositorioDeFinanceiroLancamento->obterParaDashboard(),
        );
    }

    public static function obterParametroPadraoBase($rota, $funcaoExtra = array()){
        HelperDeControllerBase::carregarSessaoBase();
        return array(
            'empresaFilial' => HelperDeSessao::get(SessaoControllerEnum::EmpresaFilial),
            'configuracao' => Session::get(SessaoControllerEnum::ConfiguracaoPadrao),
            'rota' => $rota,
            'notificacaoes' => HelperDeSessao::get(SessaoControllerEnum::Notificacao),
            'notificacaoContador' => 0,//HelperDeSessao::get(SessaoControllerEnum::Notificacao)->count(),
            'parametroExtra' => $funcaoExtra
        );
    }

    public static function obterRotinaIndex($rota, $gridView, $funcaoExtra = array()){
        $retorno = HelperDeControllerBase::obterParametroPadraoBase($rota, $funcaoExtra);
        $view = $gridView;

        if($gridView == ''){
            $retorno = MapperExtension::mapear($retorno, HelperDeControllerBase::obterParametroHome());
            $view = 'home';
        }

        return view($view, $retorno);
    }


    public static function carregarSessaoBase(){
        if(!Session::has(SessaoControllerEnum::ConfiguracaoPadrao))
            Session::put(SessaoControllerEnum::ConfiguracaoPadrao, ConfiguracaoPadrao::get()->first());

        Notificacao::obterParaHome();
    }
}