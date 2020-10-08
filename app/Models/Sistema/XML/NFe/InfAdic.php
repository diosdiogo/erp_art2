<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

// Calculo de carga tributária similar ao IBPT - Lei 12.741/12
class InfAdic
{   
    private $federal;
    private $estadual;
    private $municipal;
    private $totalT;
    private $textoIBPT;
    private $infAdFisco = "";
    private $infCpl = "";
    private $icmsTotal;

    public function __construct($nfe, $icmsTotal)
    {
         $this->nfe = $nfe;
         $this->icmsTotal = $icmsTotal;
    }

    public function getFederal(){
        return number_format($this->icmsTotal->getVII() + $this->icmsTotal->getVIPI() + $this->icmsTotal->getVIOF() + $this->icmsTotal->getVPIS() + $this->icmsTotal->getVCOFINS(), 2, ',', '.');
    }

    public function getEstadual(){
        return number_format($this->icmsTotal->getVICMS() + $this->icmsTotal->getVST(), 2, ',', '.');
    }

    public function getMunicipal(){
        return number_format($this->icmsTotal->getVISS(), 2, ',', '.');
    }

    public function getTotalT(){
        return number_format($this->getFederal() + $this->getEstadual() + $this->getMunicipal(), 2, ',', '.');
    }

    public function getTextoIBPT(){
        $this->textoIBPT = "Valor Aprox. Tributos R$ ". $this->getTotalT(). " - ". $this->getFederal(). " Federal, ". $this->getEstadual(). " Estadual e ". $this->getMunicipal(). " Municipal.";
        return $this->textoIBPT;
    }
        
    public function getInfAdFisco(){
		return $this->infAdFisco;
	}

	public function getInfCpl(){
        //$this->infCpl = 'I - "DOCUMENTO EMITIDO POR ME OU EPP OPTANTE PELO SIMPLES NACIONAL" II - "NAO GERA DIREITO A CREDITO DE ICMS, DE ISS E DE IPI".';//.  "Pedido - ". $this->getTextoIBPT();
		return $this->infCpl;
	}

    public function obterTag(){
        return $this->nfe->taginfAdic($this->getInfAdFisco(), $this->getInfCpl());
    } 
}
