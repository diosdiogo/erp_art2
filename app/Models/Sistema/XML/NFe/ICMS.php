<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

//ICMS - Imposto sobre Circulação de Mercadorias e Serviços
class ICMS
{
    private $nItem;
    private $orig;
    private $cst;
    private $modBC;
    private $pRedBC;
    private $vBC;
    private $pICMS;
    private $vICMS;
    private $vICMSDeson;
    private $motDesICMS;
    private $modBCST;
    private $pMVAST;
    private $pRedBCST;
    private $vBCST;
    private $pICMSST;
    private $vICMSST;
    private $pDif;
    private $vICMSDif;
    private $vICMSOp;
    private $vBCSTRet;
    private $vICMSSTRet;
	private $csosn;
	private $pCredSN;
	private $vCredICMSSN;
	private $CRT;

    public function __construct($nfe, $CRT)
    {
         $this->nfe = $nfe;
		 $this->CRT = $CRT;
    }

    public function getNItem(){
		return $this->nItem;
	}

	public function setNItem($nItem){
		$this->nItem = $nItem;
	}

	public function getOrig(){
		return $this->orig;
	}

	public function setOrig($orig){
		$this->orig = $orig;
	}

	public function getCst(){
		return $this->cst;
	}

	public function setCst($cst){
		$this->cst = $cst;
	}

	public function getModBC(){
		return $this->modBC;
	}

	public function setModBC($modBC){
		$this->modBC = $modBC;
	}

	public function getPRedBC(){
		return $this->pRedBC;
	}

	public function setPRedBC($pRedBC){
		$this->pRedBC = $pRedBC;
	}

	public function getVBC(){
		return $this->vBC;
	}

	public function setVBC($vBC){
		$this->vBC = $vBC;
	}

	public function getPICMS(){
		return $this->pICMS;
	}

	public function setPICMS($pICMS){
		$this->pICMS = $pICMS;
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

	public function getMotDesICMS(){
		return $this->motDesICMS;
	}

	public function setMotDesICMS($motDesICMS){
		$this->motDesICMS = $motDesICMS;
	}

	public function getModBCST(){
		return $this->modBCST;
	}

	public function setModBCST($modBCST){
		$this->modBCST = $modBCST;
	}

	public function getPMVAST(){
		return $this->pMVAST;
	}

	public function setPMVAST($pMVAST){
		$this->pMVAST = $pMVAST;
	}

	public function getPRedBCST(){
		return $this->pRedBCST;
	}

	public function setPRedBCST($pRedBCST){
		$this->pRedBCST = $pRedBCST;
	}

	public function getVBCST(){
		return $this->vBCST;
	}

	public function setVBCST($vBCST){
		$this->vBCST = $vBCST;
	}

	public function getPICMSST(){
		return $this->pICMSST;
	}

	public function setPICMSST($pICMSST){
		$this->pICMSST = $pICMSST;
	}

	public function getVICMSST(){
		return $this->vICMSST;
	}

	public function setVICMSST($vICMSST){
		$this->vICMSST = $vICMSST;
	}

	public function getPDif(){
		return $this->pDif;
	}

	public function setPDif($pDif){
		$this->pDif = $pDif;
	}

	public function getVICMSDif(){
		return $this->vICMSDif;
	}

	public function setVICMSDif($vICMSDif){
		$this->vICMSDif = $vICMSDif;
	}

	public function getVICMSOp(){
		return $this->vICMSOp;
	}

	public function setVICMSOp($vICMSOp){
		$this->vICMSOp = $vICMSOp;
	}

	public function getVBCSTRet(){
		return $this->vBCSTRet;
	}

	public function setVBCSTRet($vBCSTRet){
		$this->vBCSTRet = $vBCSTRet;
	}

	public function getVICMSSTRet(){
		return $this->vICMSSTRet;
	}

	public function setVICMSSTRet($vICMSSTRet){
		$this->vICMSSTRet = $vICMSSTRet;
	}

	public function getCsosn(){
		return $this->csosn;
	}

	public function setCsosn($csosn){
		$this->csosn = $csosn;
	}

	public function getPCredSN(){
		return $this->pCredSN;
	}

	public function setPCredSN($pCredSN){
		$this->pCredSN = $pCredSN;
	}

	public function getVCredICMSSN(){
		return $this->vCredICMSSN;
	}

	public function setVCredICMSSN($vCredICMSSN){
		$this->vCredICMSSN = $vCredICMSSN;
	}

    public function obterTag(){
		if($this->CRT != "1"){
			return $this->nfe->tagICMS($this->nItem, $this->orig, $this->cst, $this->modBC, $this->pRedBC, $this->vBC, $this->pICMS, $this->vICMS, $this->vICMSDeson, $this->motDesICMS,
			$this->modBCST, $this->pMVAST, $this->pRedBCST, $this->vBCST, $this->pICMSST, $this->vICMSST, $this->pDif, $this->vICMSDif, $this->vICMSOp, $this->vBCSTRet, $this->vICMSSTRet);
        }else{
            return $this->nfe->tagICMSSN($this->nItem, $this->orig, $this->csosn, $this->modBC, $this->vBC, $this->pRedBC, $this->pICMS, $this->vICMS, $this->pCredSN, $this->vCredICMSSN, $this->modBCST,
             $this->pMVAST, $this->pRedBCST, $this->vBCST, $this->pICMSST, $this->vICMSST, $this->vBCSTRet, $this->vICMSSTRet);
        }
    }
}
