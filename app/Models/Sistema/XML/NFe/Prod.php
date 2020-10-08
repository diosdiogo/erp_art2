<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class Prod
{   
    private $nItem;
    private $cProd;
    private $cEAN;
    private $xProd;
    private $NCM;
    private $EXTIPI;
    private $CFOP;
    private $uCom;
    private $qCom;
    private $vUnCom;
    private $vProd;
    private $cEANTrib;
    private $uTrib;
    private $qTrib;
    private $vUnTrib;
    private $vFrete;
    private $vSeg;
    private $vDesc;
    private $vOutro;
    private $indTot;
    private $xPed;
    private $nItemPed;
    private $nFCI;  

    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

    public function getNItem(){
		return $this->nItem;
	}

	public function setNItem($nItem){
		$this->nItem = $nItem;
	}

	public function getCProd(){
		return $this->cProd;
	}

	public function setCProd($cProd){
		$this->cProd = $cProd;
	}

	public function getCEAN(){
		return $this->cEAN;
	}

	public function setCEAN($cEAN){
		$this->cEAN = $cEAN;
	}

	public function getXProd(){
		return $this->xProd;
	}

	public function setXProd($xProd){
		$this->xProd = $xProd;
	}

	public function getNCM(){
		return $this->NCM;
	}

	public function setNCM($NCM){
		$this->NCM = $NCM;
	}

	public function getEXTIPI(){
		return $this->EXTIPI;
	}

	public function setEXTIPI($EXTIPI){
		$this->EXTIPI = $EXTIPI;
	}

	public function getCFOP(){
		return $this->CFOP;
	}

	public function setCFOP($CFOP){
		$this->CFOP = $CFOP;
	}

	public function getUCom(){
		return $this->uCom;
	}

	public function setUCom($uCom){
		$this->uCom = $uCom;
	}

	public function getQCom(){
		return $this->qCom;
	}

	public function setQCom($qCom){
		$this->qCom = $qCom;
	}

	public function getVUnCom(){
		return $this->vUnCom;
	}

	public function setVUnCom($vUnCom){
		$this->vUnCom = $vUnCom;
	}

	public function getVProd(){
		return $this->vProd;
	}

	public function setVProd($vProd){
		$this->vProd = $vProd;
	}

	public function getCEANTrib(){
		return $this->cEANTrib;
	}

	public function setCEANTrib($cEANTrib){
		$this->cEANTrib = $cEANTrib;
	}

	public function getUTrib(){
		return $this->uTrib;
	}

	public function setUTrib($uTrib){
		$this->uTrib = $uTrib;
	}

	public function getQTrib(){
		return $this->qTrib;
	}

	public function setQTrib($qTrib){
		$this->qTrib = $qTrib;
	}

	public function getVUnTrib(){
		return $this->vUnTrib;
	}

	public function setVUnTrib($vUnTrib){
		$this->vUnTrib = $vUnTrib;
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

	public function getVOutro(){
		return $this->vOutro;
	}

	public function setVOutro($vOutro){
		$this->vOutro = $vOutro;
	}

	public function getIndTot(){
		return $this->indTot;
	}

	public function setIndTot($indTot){
		$this->indTot = $indTot;
	}

	public function getXPed(){
		return $this->xPed;
	}

	public function setXPed($xPed){
		$this->xPed = $xPed;
	}

	public function getNItemPed(){
		return $this->nItemPed;
	}

	public function setNItemPed($nItemPed){
		$this->nItemPed = $nItemPed;
	}

	public function getNFCI(){
		return $this->nFCI;
	}

	public function setNFCI($nFCI){
		$this->nFCI = $nFCI;
	}
    
    public function obterTag(){
        return $this->nfe->tagprod($this->nItem, $this->cProd, $this->cEAN, $this->xProd, $this->NCM, $this->EXTIPI, $this->CFOP, $this->uCom, $this->qCom, $this->vUnCom, $this->vProd, $this->cEANTrib,
         $this->uTrib, $this->qTrib, $this->vUnTrib, $this->vFrete, $this->vSeg, $this->vDesc, $this->vOutro, $this->indTot, $this->xPed, $this->nItemPed, $this->nFCI);
    } 
}