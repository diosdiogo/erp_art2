<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

//IPI - Imposto sobre Produto Industrializado
class IPI
{   
    private $nItem; //produtos 1
    private $cst; // 50 - Saída Tributada (Código da Situação Tributária)
    private $clEnq;
    private $cnpjProd;
    private $cSelo;
    private $qSelo;
    private $cEnq;
    private $vBC;
    private $pIPI; //Calculo por alíquota - 6% Alíquota.
    private $qUnid;
    private $vUnid;
    private $vIPI; // = $vBC * ( $pIPI / 100 )
    
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

	public function getClEnq(){
		return $this->clEnq;
	}

	public function setClEnq($clEnq){
		$this->clEnq = $clEnq;
	}

	public function getCnpjProd(){
		return $this->cnpjProd;
	}

	public function setCnpjProd($cnpjProd){
		$this->cnpjProd = $cnpjProd;
	}

	public function getCSelo(){
		return $this->cSelo;
	}

	public function setCSelo($cSelo){
		$this->cSelo = $cSelo;
	}

	public function getQSelo(){
		return $this->qSelo;
	}

	public function setQSelo($qSelo){
		$this->qSelo = $qSelo;
	}

	public function getCEnq(){
		return $this->cEnq;
	}

	public function setCEnq($cEnq){
		$this->cEnq = $cEnq;
	}

	public function getVBC(){
		return $this->vBC;
	}

	public function setVBC($vBC){
		$this->vBC = $vBC;
	}

	public function getPIPI(){
		return $this->pIPI;
	}

	public function setPIPI($pIPI){
		$this->pIPI = $pIPI;
	}

	public function getQUnid(){
		return $this->qUnid;
	}

	public function setQUnid($qUnid){
		$this->qUnid = $qUnid;
	}

	public function getVUnid(){
		return $this->vUnid;
	}

	public function setVUnid($vUnid){
		$this->vUnid = $vUnid;
	}

	public function getVIPI(){
		return $this->vIPI;
	}

	public function setVIPI($vIPI){
		$this->vIPI = $vIPI;
	}

    public function obterTag(){
        return $this->nfe->tagIPI($this->nItem, $this->cst, $this->clEnq, $this->cnpjProd, $this->cSelo, $this->qSelo,
        $this->cEnq, $this->vBC, $this->pIPI, $this->qUnid, $this->vUnid, $this->vIPI);
    } 
}