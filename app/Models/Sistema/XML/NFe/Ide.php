<?php
namespace App\Models\Sistema\XML\NFe;

use App\Constants\NFe\NfeConstant;

class Ide
{   
    private $cUF = "35"; //codigo numerico do estado
    private $cNF = "0"; //numero aleatório da NF
    private $natOp = "Venda de Produto"; //natureza da operação
    private $indPag = "1"; //0=Pagamento à vista; 1=Pagamento a prazo; 2=Outros
    private $mod = "55"; //modelo da NFe 55 ou 65 essa última NFCe
    private $serie = "1"; //serie da NFe
    private $nNF = "10"; // numero da NFe
    private $dhEmi; //Formato: “AAAA-MM-DDThh:mm:ssTZD” (UTC - Universal Coordinated Time).
    private $dhSaiEnt; //Não informar este campo para a NFC-e.
    private $tpNF = "1";
    private $idDest = "1"; //1=Operação interna; 2=Operação interestadual; 3=Operação com exterior.
    private $cMunFG = "";
    private $tpImp = "1";  //0=Sem geração de DANFE; 1=DANFE normal, Retrato; 2=DANFE normal, Paisagem;
                    //3=DANFE Simplificado; 4=DANFE NFC-e; 5=DANFE NFC-e em mensagem eletrônica
                    //(o envio de mensagem eletrônica pode ser feita de forma simultânea com a impressão do DANFE;
                    //usar o tpImp=5 quando esta for a única forma de disponibilização do DANFE).
    private $tpEmis = "1"; //1=Emissão normal (não em contingência);
                    //2=Contingência FS-IA, com impressão do DANFE em formulário de segurança;
                    //3=Contingência SCAN (Sistema de Contingência do Ambiente Nacional);
                    //4=Contingência DPEC (Declaração Prévia da Emissão em Contingência);
                    //5=Contingência FS-DA, com impressão do DANFE em formulário de segurança;
                    //6=Contingência SVC-AN (SEFAZ Virtual de Contingência do AN);
                    //7=Contingência SVC-RS (SEFAZ Virtual de Contingência do RS);
                    //9=Contingência off-line da NFC-e (as demais opções de contingência são válidas também para a NFC-e);
                    //Nota: Para a NFC-e somente estão disponíveis e são válidas as opções de contingência 5 e 9.
    private $tpAmb = "2"; //1=Produção; 2=Homologação
    private $finNFe = "1"; //1=NF-e normal; 2=NF-e complementar; 3=NF-e de ajuste; 4=Devolução/Retorno.
    private $indFinal = "0";  //0=Normal; 1=Consumidor final;
    private $indPres = "9"; //0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste);
                    //1=Operação presencial;
                    //2=Operação não presencial, pela Internet;
                    //3=Operação não presencial, Teleatendimento;
                    //4=NFC-e em operação com entrega a domicílio;
                    //9=Operação não presencial, outros.
    private $procEmi = "0"; //0 = Emissão de NF-e com aplicativo do contribuinte;
                        //1=Emissão de NF-e avulsa pelo Fisco;
                        //2=Emissão de NF-e avulsa, pelo contribuinte com seu certificado digital, através do site do Fisco;
                        //3=Emissão NF-e pelo contribuinte com aplicativo fornecido pelo Fisco.
    private $verProc = "4.0.43"; //versão do aplicativo emissor
    private $dhCont = "";  //entrada em contingência AAAA-MM-DDThh:mm:ssTZD
    private $xJust = "";  //Justificativa da entrada em contingência
    private $cDV = "";

    public function __construct($nfe)
    {
         $this->nfe = $nfe;
    }

	public function setcDV($cDV){
		$this->cDV = $cDV;
	}

  	public function getcUF(){
		return $this->cUF;
	}

	public function setcUF($cUF){
		$this->cUF = $cUF;
	}

	public function getcNF(){
		return $this->cNF;
	}

	public function setCNF($cNF){
		$this->cNF = $cNF;
	}

	public function getNatOp(){
		return $this->natOp;
	}

	public function setNatOp($natOp){
		$this->natOp = $natOp;
	}

	public function getIndPag(){
		return $this->indPag;
	}

	public function setIndPag($indPag){
		$this->indPag = $indPag;
	}

	public function getMod(){
		return $this->mod;
	}

	public function setMod($mod){
		$this->mod = $mod;
	}

	public function getSerie(){
		return $this->serie;
	}

	public function setSerie($serie){
		$this->serie = $serie;
	}

	public function getnNF(){
		return $this->nNF;
	}

	public function setnNF($nNF){
		$this->nNF = $nNF;
	}

	public function getDhEmi(){
		return date("Y-m-d\TH:i:sP");
	}

	public function getDhSaiEnt(){
		return date("Y-m-d\TH:i:sP");
	}

	public function getTpNF(){
		return $this->tpNF;
	}

	public function setTpNF($tpNF){
		$this->tpNF = $tpNF;
	}

	public function getIdDest(){
		return $this->idDest;
	}

	public function setIdDest($idDest){
		$this->idDest = $idDest;
	}

	public function getcMunFG(){
		return $this->cMunFG;
	}

	public function setcMunFG($cMunFG){
		$this->cMunFG = $cMunFG;
	}

	public function getTpImp(){
		return $this->tpImp;
	}

	public function setTpImp($tpImp){
		$this->tpImp = $tpImp;
	}

	public function getTpEmis(){
		return $this->tpEmis;
	}

	public function setTpEmis($tpEmis){
		$this->tpEmis = $tpEmis;
	}

	public function getTpAmb(){
		return $this->tpAmb;
	}

	public function setTpAmb($tpAmb){
		$this->tpAmb = $tpAmb;
	}

	public function getFinNFe(){
		return $this->finNFe;
	}

	public function setFinNFe($finNFe){
		$this->finNFe = $finNFe;
	}

	public function getIndFinal(){
		return $this->indFinal;
	}

	public function setIndFinal($indFinal){
		$this->indFinal = $indFinal;
	}

	public function getIndPres(){
		return $this->indPres;
	}

	public function setIndPres($indPres){
		$this->indPres = $indPres;
	}

	public function getProcEmi(){
		return $this->procEmi;
	}

	public function setProcEmi($procEmi){
		$this->procEmi = $procEmi;
	}

	public function getVerProc(){
		return $this->verProc;
	}

	public function setVerProc($verProc){
		$this->verProc = $verProc;
	}

	public function getDhCont(){
		return $this->dhCont;
	}

	public function setDhCont($dhCont){
		$this->dhCont = $dhCont;
	}

	public function getXJust(){
		return $this->xJust;
	}

	public function setXJust($xJust){
		$this->xJust = $xJust;
	}

    public function obterTag(){
        return $this->nfe->tagide($this->cUF, $this->cNF, $this->natOp, $this->indPag, $this->mod, $this->serie, $this->nNF, $this->getDhEmi(), $this->getDhSaiEnt(),
         $this->tpNF, $this->idDest, $this->cMunFG, $this->tpImp, $this->tpEmis, $this->cDV, $this->tpAmb, $this->finNFe, $this->indFinal, $this->indPres, $this->procEmi,
         $this->verProc, $this->dhCont, $this->xJust);
    } 
}
