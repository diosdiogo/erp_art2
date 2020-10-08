<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class COFINS
{   
    private $nItem;
    private $cst;
    private $vBC;
	private $pCOFINS;
    private $vCOFINS;
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

	public function getPCOFINS(){
		return $this->pCOFINS;
	}

	public function setPCOFINS($pCOFINS){
		$this->pCOFINS = $pCOFINS;
	}

	public function getVCOFINS(){
		return $this->vCOFINS;
	}

	public function setVCOFINS($vCOFINS){
		$this->vCOFINS = $vCOFINS;
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
        return $this->nfe->tagCOFINS($this->nItem, $this->cst, $this->vBC, $this->pCOFINS, $this->vCOFINS, $this->qBCProd, $this->vAliqProd);
    } 
}