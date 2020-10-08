<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class NFeConsulta
{   
    public $retorno;
    
    private $bStat;
    private $versao;
    private $tpAmb;
    private $cStat;
    private $verAplic;
    private $xMotivo;
    private $dhRecbto;
    private $cUF;
    private $nRec;
    
    public function __construct($retorno)
    {
         $this->retorno = $retorno;
    }

    public function getbStat(){
        return $this->retorno['bStat'];    
    }

    public function getVersao(){
        return $this->retorno['versao'];    
    }

    public function gettpAmb(){
        return $this->retorno['tpAmb'];    
    }

    public function getVerAplic(){
        return $this->retorno['verAplic'];    
    }

    public function getxMotivo(){
        return $this->retorno['xMotivo'];    
    }

    public function getcUF(){
        return $this->retorno['cUF'];    
    }    

    public function getnRec(){
        return $this->retorno['nRec'];    
    }        
}