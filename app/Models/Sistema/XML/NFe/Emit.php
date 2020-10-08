<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class Emit
{
    private $CNPJ;
    private $CPF;
    private $xNome;
    private $xFant;
    private $IE;
    private $IEST;
    private $IM;
    private $CNAE;    
    private $CRT;

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

	public function getXNome(){
		return $this->xNome;
	}

	public function setXNome($xNome){
		$this->xNome = $xNome;
	}

	public function getXFant(){
		return $this->xFant;
	}

	public function setXFant($xFant){
		$this->xFant = $xFant;
	}

	public function getIE(){
		return $this->IE;
	}

	public function setIE($IE){
		$this->IE = $IE;
	}

	public function getIEST(){
		return $this->IEST;
	}

	public function setIEST($IEST){
		$this->IEST = $IEST;
	}

	public function getIM(){
		return $this->IM;
	}

	public function setIM($IM){
		$this->IM = $IM;
	}

	public function getCNAE(){
		return $this->CNAE;
	}

	public function setCNAE($CNAE){
		$this->CNAE = $CNAE;
	}

	public function getCRT(){
		return $this->CRT;
	}

	public function setCRT($CRT){
		$this->CRT = $CRT;
	}
        
    public function obterTag(){
        return $this->nfe->tagemit($this->CNPJ, $this->CPF, $this->xNome, $this->xFant, $this->IE, $this->IEST, $this->IM, $this->CNAE, $this->CRT);
    } 
}
