<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class EnderEmit
{   
    private $xLgr;
    private $nro;
    private $xCpl;
    private $xBairro;
    private $cMun;
    private $xMun;
    private $UF;
    private $CEP;    
    private $cPais;
    private $xPais;    
    private $fone;

    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

    public function getXLgr(){
		return $this->xLgr;
	}

	public function setXLgr($xLgr){
		$this->xLgr = $xLgr;
	}

	public function getNro(){
		return $this->nro;
	}

	public function setNro($nro){
		$this->nro = $nro;
	}

	public function getXCpl(){
		return $this->xCpl;
	}

	public function setXCpl($xCpl){
		$this->xCpl = $xCpl;
	}

	public function getXBairro(){
		return $this->xBairro;
	}

	public function setXBairro($xBairro){
		$this->xBairro = $xBairro;
	}

	public function getCMun(){
		return $this->cMun;
	}

	public function setCMun($cMun){
		$this->cMun = $cMun;
	}

	public function getXMun(){
		return $this->xMun;
	}

	public function setXMun($xMun){
		$this->xMun = $xMun;
	}

	public function getUF(){
		return $this->UF;
	}

	public function setUF($UF){
		$this->UF = $UF;
	}

	public function getCEP(){
		return $this->CEP;
	}

	public function setCEP($CEP){
		$this->CEP = $CEP;
	}

	public function getCPais(){
		return $this->cPais;
	}

	public function setCPais($cPais){
		$this->cPais = $cPais;
	}

	public function getXPais(){
		return $this->xPais;
	}

	public function setXPais($xPais){
		$this->xPais = $xPais;
	}

	public function getFone(){
		return $this->fone;
	}

	public function setFone($fone){
		$this->fone = $fone;
	}

    public function obterTag(){
        return $this->nfe->tagenderEmit($this->xLgr, $this->nro, $this->xCpl, $this->xBairro, $this->cMun, $this->xMun, $this->UF, $this->CEP, $this->cPais, $this->xPais, $this->fone);
    } 
}
