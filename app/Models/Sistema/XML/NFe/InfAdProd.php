<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class InfAdProd
{   
    private $nItem;
    private $vDesc;
    
    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

    public function getnItem(){
		return $this->nItem;
	}

	public function setnItem($nItem){
		$this->nItem = $nItem;
	}

	public function getvDesc(){
		return $this->vDesc;
	}

	public function setvDesc($vDesc){
		$this->vDesc = $vDesc;
	}
    public function obterTag(){
        return $this->nfe->taginfAdProd($this->nItem, $this->vDesc);
    } 
}