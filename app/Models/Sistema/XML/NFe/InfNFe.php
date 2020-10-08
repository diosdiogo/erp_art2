<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class InfNFe
{   
    private $ano;
    private $mes;
    private $cnpj;
    private $chave;
    private $versao;
    private $cDV;
    private $nfe;

    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

    function getAno() {
        return $this->ano;
    }

    function setAno($ano) {
        $this->ano = $ano;
    }

    function getMes() {
        return $this->mes;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function getCnpj() {
        return $this->cnpj;
    }

    function setCnpj($cnpj) {
        $this->cnpj = $cnpj;
    }

    function getVersao() {
        return NfeConstant::VERSAO;
    }
    
    public function obterTag(){
        return $this->nfe->taginfNFe((\stdClass)$this);
    } 
}
