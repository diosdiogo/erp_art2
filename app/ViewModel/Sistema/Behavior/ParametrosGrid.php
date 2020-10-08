<?php

namespace App\ViewModel\Sistema\Behavior;

use App\ViewModel\BaseViewModel;
use App\Helper\Sessao\HelperDeSessao;
use App\Enums\Sessao\SessaoControllerEnum;

class ParametrosGrid extends BaseViewModel {

    public $id;
    public $idEmpresa = "1";
    public $expressao = "";
    public $obterPorEmpresa = true;
    public $expressaoArray = array();
    public $dataInicial = null;
    public $dataFinal = null;
    public $idDropDrownList = null;

    public function __construct()
    {
        parent::__construct();
        $this->expressao = $this->obterPorEmpresa ? $this->obterExpressaoPorEmpresa() : "";
    }

    public function obterExpressao(){
        $expressao = collect($this->expressaoArray);
        $expressaoRetorno = $this->obterExpressaoPorEmpresa();
        $expressao->each(function ($item, $key) use(&$expressaoRetorno, &$expressaoArray) {
            $adicionarOperador = collect($expressaoArray)->count() > 1 && collect($item)->has(3) ? " $item[3] " : "";
            $expressaoRetorno .= $item[0] . " $item[1]" . " $item[2]" . $adicionarOperador;
        });

        return $expressaoRetorno;
    }

    public function pOrderByAsc($campo){
        $this->expressao .= " ORDER BY $campo ASC";
    }

    public function pOrderByDesc($campo){
        $this->expressao .= " ORDER BY $campo DESC";
    }

    public function pBetweenAnd($campo){
        $dataInicial = $this->obterDataInicial();
        $dataFinal = $this->obterDataFinal();
        if($this->permitePesquisarDatas() && $dataInicial != null && $dataFinal != null){
            $this->expressao .= $this->adicionarOperador('AND') . " $campo BETWEEN '$dataInicial' AND '$dataFinal'";
            HelperDeSessao::put(SessaoControllerEnum::DataInicial, $dataInicial);
            HelperDeSessao::put(SessaoControllerEnum::DataFinal, $dataFinal);
        }

        return $this;
    }

    public function pAnd($campo, $valor){
        if($valor != "")
            $this->expressao .= $this->adicionarOperador('AND') . " $campo = $valor";

        return $this;
    }

    public function pRemoverExpressao(){
        $this->expressao = "false";
    }

    public function pPadrao($classe = ''){
        $valor = $this->obterId();
        if($this->expressao == "idempresa = 1" && $valor > 0){
            $this->expressao .= $this->adicionarOperador('AND') .   " $classe.id = $valor";
        }

        if($classe != '')
            $this->expressao = str_replace('idempresa', "$classe.idempresa", $this->expressao);

        return $this;
    }

    public function pAndLike($campo, $valor){
        if($valor != "")
            $this->expressao .= $this->adicionarOperador('AND') . " $campo like '%$valor%'";

        return $this;
    }

    public function pOrLike($campo, $valor){
        if($valor != "")
            $this->expressao .= $this->adicionarOperador('OR') . " $campo like '%$valor%'";

        return $this;
    }

    private function adicionarOperador($operador){
        return $this->expressao ? ' ' .$operador : "";
    }

    private function obterExpressaoPorEmpresa(){
        return $this->obterPorEmpresa ? "idempresa = $this->idEmpresa" : "";
    }

    public function obterIdFiltro(){
        return $this->obterItem('idFiltro');
    }

    public function obterDataInicial(){
        return $this->obterItem('dataInicial');
    }

    public function obterIdDropDrownList(){
        return $this->obterItem('idDropDrownList');
    }

    public function obterDataFinal(){
        return $this->obterItem('dataFinal');
    }

    public function permitePesquisarDatas(){
        return filter_var($this->obterItem('pesquisarDatas'), FILTER_VALIDATE_BOOLEAN);
    }

    public function obterParametro(){
        $parametro = $this->obterItem('parametro');
        return $parametro == "" ? $this->obterId() : $parametro;
    }

    public function obterId(){
        return $this->obterItem('id');
    }

    public function rules()
    {
        return [
          //  'descricao' => 'required',
        ];
    }
}