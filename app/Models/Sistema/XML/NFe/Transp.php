<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class Transp
{   
    private $modFrete;
    
    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

    public function getModFrete(){
		return $this->modFrete;
	}

	public function setModFrete($modFrete){
		$this->modFrete = $modFrete;
	}

    public function obterTag(){
        return $this->nfe->tagtransp($this->modFrete);
    } 
}