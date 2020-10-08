<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class PIS
{   
    private $nItem;
    private $cst;
    private $vBC;
    private $pPIS;
    private $vPIS;
    private $qBCProd;
    private $vAliqProd;
    
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

	public function getCst(){
		return $this->cst;
	}

	public function setCst($cst){
		$this->cst = $cst;
	}

	public function getVBC(){
		return $this->vBC;
	}

	public function setVBC($vBC){
		$this->vBC = $vBC;
	}

	public function getPPIS(){
		return $this->pPIS;
	}

	public function setPPIS($pPIS){
		$this->pPIS = $pPIS;
	}

	public function getVPIS(){
		return $this->vPIS;
	}

	public function setVPIS($vPIS){
		$this->vPIS = $vPIS;
	}

	public function getQBCProd(){
		return $this->qBCProd;
	}

	public function setQBCProd($qBCProd){
		$this->qBCProd = $qBCProd;
	}

	public function getVAliqProd(){
		return $this->vAliqProd;
	}

	public function setVAliqProd($vAliqProd){
		$this->vAliqProd = $vAliqProd;
	}

    public function obterTag(){
        return $this->nfe->tagPIS($this->nItem, $this->cst, $this->vBC, $this->pPIS, $this->vPIS, $this->qBCProd, $this->vAliqProd);
    } 
}