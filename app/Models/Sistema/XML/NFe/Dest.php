<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class Dest
{   
    private $CNPJ;
    private $CPF;
    private $idEstrangeiro;
    private $xNome;
    private $indIEDest;
    private $IE;
    private $ISUF;
    private $IM;    
    private $email;
    
    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

	public function getCNPJ(){
		return $this->CNPJ;
	}

	public function setCNPJ($CNPJ){
		$this->CNPJ = $CNPJ;
	}

	public function getCPF(){
		return $this->CPF;
	}

	public function setCPF($CPF){
		$this->CPF = $CPF;
	}

	public function getIdEstrangeiro(){
		return $this->idEstrangeiro;
	}

	public function setIdEstrangeiro($idEstrangeiro){
		$this->idEstrangeiro = $idEstrangeiro;
	}

	public function getXNome(){
		return $this->xNome;
	}

	public function setXNome($xNome){
		$this->xNome = $xNome;
	}

	public function getIndIEDest(){
		return $this->indIEDest;
	}

	public function setIndIEDest($indIEDest){
		$this->indIEDest = $indIEDest;
	}

	public function getIE(){
		return $this->IE;
	}

	public function setIE($IE){
		$this->IE = $IE;
	}

	public function getISUF(){
		return $this->ISUF;
	}

	public function setISUF($ISUF){
		$this->ISUF = $ISUF;
	}

	public function getIM(){
		return $this->IM;
	}

	public function setIM($IM){
		$this->IM = $IM;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}
        
    public function obterTag(){
        return $this->nfe->tagdest($this->CNPJ, $this->CPF, $this->idEstrangeiro, $this->xNome, $this->indIEDest, $this->IE, $this->ISUF, $this->IM, $this->email);
    } 
}
