<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class Imposto
{
    private $nItem;
    private $vTotTrib;
    private $icms;
    private $ipi;
    private $pis;
    private $cofins;

    public function __construct($nfe, $icms, $ipi, $pis, $cofins)
    {
         $this->nfe = $nfe;
         $this->icms = $icms;
         $this->ipi = $ipi;
         $this->pis = $pis;
         $this->cofins = $cofins;
    }

    public function getnItem(){
		return $this->nItem;
	}

	public function setnItem($nItem){
		$this->nItem = $nItem;
	}

	public function getvTotTrib(){
        $this->setvTotTrib($this->icms->getvICMS() + $this->ipi->getvIPI() + $this->pis->getvPIS() + $this->cofins->getvCOFINS());
		return $this->vTotTrib;
	}

	public function setvTotTrib($vTotTrib){
		$this->vTotTrib = number_format($vTotTrib, 2, '.', '');
	}


    public function obterTag(){
        return $this->nfe->tagimposto($this->nItem, $this->vTotTrib);
    }
}
