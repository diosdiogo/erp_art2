<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class ICMSTot
{
    private $vBC;
    private $vICMS;
    private $vICMSDeson;
    private $vBCST;
    private $vST;
    private $vProd;
    private $vFrete;
    private $vSeg;
    private $vDesc;
    private $vII;
    private $vIPI;
    private $vPIS;
    private $vCOFINS;
    private $vOutro;
    private $vNF;
    private $vTotTrib;
	private $vIOF = "0";
	private $VISS = "0";

    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

	public function getVISS(){
		return $this->VISS;
	}

	public function setVISS($VISS){
		$this->VISS = $VISS;
	}

	public function getVIOF(){
		return $this->vIOF;
	}

	public function setVIOF($vIOF){
		$this->vIOF = $vIOF;
	}

	public function getVBC(){
		return $this->vBC;
	}

	public function setVBC($vBC){
		$this->vBC = $vBC;
	}

	public function getVICMS(){
		return $this->vICMS;
	}

	public function setVICMS($vICMS){
		$this->vICMS = $vICMS;
	}

	public function getVICMSDeson(){
		return $this->vICMSDeson;
	}

	public function setVICMSDeson($vICMSDeson){
		$this->vICMSDeson = $vICMSDeson;
	}

	public function getVBCST(){
		return $this->vBCST;
	}

	public function setVBCST($vBCST){
		$this->vBCST = $vBCST;
	}

	public function getVST(){
		return $this->vST;
	}

	public function setVST($vST){
		$this->vST = $vST;
	}

	public function getVProd(){
		return $this->vProd;
	}

	public function setVProd($vProd){
		$this->vProd = $vProd;
	}

	public function getVFrete(){
		return $this->vFrete;
	}

	public function setVFrete($vFrete){
		$this->vFrete = $vFrete;
	}

	public function getVSeg(){
		return $this->vSeg;
	}

	public function setVSeg($vSeg){
		$this->vSeg = $vSeg;
	}

	public function getVDesc(){
		return $this->vDesc;
	}

	public function setVDesc($vDesc){
		$this->vDesc = $vDesc;
	}

	public function getVII(){
		return $this->vII;
	}

	public function setVII($vII){
		$this->vII = $vII;
	}

	public function getVIPI(){
		return $this->vIPI;
	}

	public function setVIPI($vIPI){
		$this->vIPI = $vIPI;
	}

	public function getVPIS(){
		return $this->vPIS;
	}

	public function setVPIS($vPIS){
		$this->vPIS = $vPIS;
	}

	public function getVCOFINS(){
		return $this->vCOFINS;
	}

	public function setVCOFINS($vCOFINS){
		$this->vCOFINS = $vCOFINS;
	}

	public function getVOutro(){
		return $this->vOutro;
	}

	public function setVOutro($vOutro){
		$this->vOutro = $vOutro;
	}

	public function getVNF(){
        $this->vNF = number_format($this->vProd-$this->vDesc-$this->vICMSDeson+$this->vST+$this->vFrete+$this->vSeg+$this->vOutro+$this->vII+$this->vIPI, 2, '.', '');
		return $this->vNF;
	}

	public function getVTotTrib(){
		return $this->vTotTrib;
	}

    public function setVTotTrib($vTrib){
		$this->vTotTrib = $vTrib;
	}

    public function obterTag(){
        return $this->nfe->tagICMSTot($this->vBC, $this->vICMS, $this->vICMSDeson, $this->vBCST, $this->vST, $this->vProd, $this->vFrete, $this->vSeg, $this->vDesc, $this->vII,
         $this->vIPI, $this->vPIS, $this->vCOFINS, $this->vOutro, $this->getVNF(), $this->vTotTrib);
    }
}