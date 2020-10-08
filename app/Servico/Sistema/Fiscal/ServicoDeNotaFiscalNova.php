<?php

namespace App\Servico\Sistema\Fiscal;

use App;
use Auth;
use Config;

/* 4.0 */
use NFePHP\NFe\Make;
use NFePHP\NFe\Tools;
use NFePHP\Common\Validator;
use Illuminate\Http\Request;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\NFe\Common\Standardize;
/* 4.0 */

use NFePHP\NFe\MakeNFe;
use NFePHP\NFe\ToolsNFe;
use NFePHP\Extras\Danfe;
use App\Helper\SessionProperties;
use App\Extension\CommonExtension;
use App\Constants\NFe\NfeConstant;
use App\Models\Sistema\Venda\Venda;
use App\Models\Sistema\XML\NFe\Ide;
use App\Models\Sistema\XML\NFe\IPI;
use App\Models\Sistema\XML\NFe\PIS;
use App\Models\Sistema\XML\NFe\Dest;
use App\Models\Sistema\XML\NFe\Emit;
use App\Models\Sistema\XML\NFe\Prod;
use App\Models\Sistema\XML\NFe\ICMS;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\XML\NFe\COFINS;
use App\Models\Sistema\XML\NFe\Transp;
use App\Models\Sistema\XML\NFe\InfNFe;
use App\Models\Sistema\XML\NFe\InfAdic;
use App\Models\Sistema\XML\NFe\Imposto;
use App\Models\Sistema\XML\NFe\ICMSTot;
use App\Models\Sistema\Empresa\Empresa;
use App\Models\Sistema\Endereco\Cidade;
use App\Models\Sistema\Endereco\Estado;
use App\Enums\FiscalRegimeTributarioEnum;
use App\Models\Sistema\XML\NFe\EnderEmit;
use App\Models\Sistema\XML\NFe\EnderDest;
use App\Models\Sistema\XML\NFe\NFeConsulta;
use App\Models\Sistema\Fiscal\NotaFiscal\NotaFiscal;
use App\Models\Sistema\Parametro\Fiscal\ParametroFiscal;
use App\Models\Sistema\Fiscal\NaturezaOperacao\FiscalNaturezaOperacao;

class ServicoDeNotaFiscalNova
{
    protected $NFeTools;
    protected $venda;
    protected $notaFiscal;
    protected $sessionProperties;
    protected $naturezaOperacao;
    protected $parametroFiscal;
    protected $empresa;
    protected $empresaCidade;
    protected $empresaEstado;
    protected $pessoa;
    protected $pessoaCidade;
    protected $pessoaEstado;
    protected $notaFiscalItens;
    protected $mensagemConexaoErro = "Falha no serviço ou conexão, aguarde 10 minutos e consulte novamente!";
    protected $produto;
    protected $produtoCSTCSOSN = array();
    protected $produtoContador = 0;
    protected $viewModel;
    protected $valorTotalICMS;
    protected $valorTotalICMSBaseCalculo;
    protected $valorTotalTributos;
    protected $CRT;
    protected $valorTotalDesconto;


    private $tools = null;
    private $certificado = null;
    private $configuracao = null;
    private $caminhoCertificado = "C:\\projetos\\ERPMobi\\NFe\\AviculturaBrasil1234.pfx";
    private $standardize = null;
    private $mensagemException = "Houve uma falha na requisição, tente novamente mais tarde";
    private $tipoAmbiente = 2;

    public function __construct(SessionProperties $sessionProperties){
        $this->sessionProperties = $sessionProperties;
        $this->configuracao = $this->obterConfiguracaoJson();
        $this->certificado = file_get_contents($this->caminhoCertificado);
        $this->tools = new Tools($this->configuracao, Certificate::readPfx($this->certificado, '1234'));
        $this->standardize = new Standardize;
    }

    private function montarNFeNova(){
        $nfe = new Make();
        $std = new \stdClass();
        
        $std->versao = '4.00';
        $std->Id = null;
        $std->pk_nItem = '';
        $nfe->taginfNFe($std);
        
        $std = new \stdClass();
        $std->cUF = 35; //coloque um código real e válido
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = 55;
        $std->serie = 1;
        $std->nNF = 11;
        $std->dhEmi = '2018-07-27T20:48:00-02:00';
        $std->dhSaiEnt = '2018-07-27T20:48:00-02:00';
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = 3506003; //Código de município precisa ser válido
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 2;
        $std->tpAmb = 2; // Se deixar o tpAmb como 2 você emitirá a nota em ambiente de homologação(teste) e as notas fiscais aqui não tem valor fiscal
        $std->finNFe = 1;
        $std->indFinal = 0;
        $std->indPres = 0;
        $std->procEmi = '0';
        $std->verProc = 1;
        $nfe->tagide($std);
        
        $std = new \stdClass();
        $std->xNome = 'AVICULTURA BRASIL AMERICANA LTDA - ME';
        $std->IE = '606223122118';
        $std->CRT = 1;
        $std->CNPJ = '02149743000153';
        $nfe->tagemit($std);
        
        $std = new \stdClass();
        $std->xLgr = "Rua Teste";
        $std->nro = '203';
        $std->xBairro = 'Centro';
        $std->cMun = 3501608; //Código de município precisa ser válido e igual o  cMunFG
        $std->xMun = 'Americana';
        $std->UF = 'SP';
        $std->CEP = '80045190';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $nfe->tagenderEmit($std);
        
        $std = new \stdClass();
        $std->xNome = 'Empresa destinatário teste';
        $std->indIEDest = 2;
        $std->IE = '146184230311';
        $std->CNPJ = '57546917000103';
        $nfe->tagdest($std);
        
        $std = new \stdClass();
        $std->xLgr = "Rua Teste";
        $std->nro = '203';
        $std->xBairro = 'Centro';
        $std->cMun = '3506003';
        $std->xMun = 'Bauru';
        $std->UF = 'SP';
        $std->CEP = '80045190';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $nfe->tagenderDest($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->cEAN = 'SEM GTIN';
        $std->cEANTrib = 'SEM GTIN';
        $std->cProd = '0001';
        $std->xProd = 'Produto teste';
        $std->NCM = '84669330';
        $std->CFOP = '5102';
        $std->uCom = 'PÇ';
        $std->qCom = '1.0000';
        $std->vUnCom = '10.99';
        $std->vProd = '10.99';
        $std->uTrib = 'PÇ';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '10.99';
        $std->indTot = 1;
        $nfe->tagprod($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->vTotTrib = 10.99;
        $nfe->tagimposto($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 0;
        $std->vBC = '0.20';
        $std->pICMS = '18.0000';
        $std->vICMS = '0.04';
        $nfe->tagICMS($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->cEnq = '999';
        $std->CST = '50';
        $std->vIPI = 0;
        $std->vBC = 0;
        $std->pIPI = 0;
        $nfe->tagIPI($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $nfe->tagPIS($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->vCOFINS = 0;
        $std->vBC = 0;
        $std->pCOFINS = 0;
        
        $nfe->tagCOFINSST($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $std->qBCProd = 0;
        $std->vAliqProd = 0;
        $nfe->tagCOFINS($std);
        
        $std = new \stdClass();
        $std->vBC = '0.20';
        $std->vICMS = 0.04;
        $std->vICMSDeson = 0.00;
        $std->vBCST = 0.00;
        $std->vST = 0.00;
        $std->vProd = 10.99;
        $std->vFrete = 0.00;
        $std->vSeg = 0.00;
        $std->vDesc = 0.00;
        $std->vII = 0.00;
        $std->vIPI = 0.00;
        $std->vPIS = 0.00;
        $std->vCOFINS = 0.00;
        $std->vOutro = 0.00;
        $std->vNF = 11.03;
        $std->vTotTrib = 0.00;
        $nfe->tagICMSTot($std);
        
        
        $std = new \stdClass();
        $std->modFrete = 1;
        $nfe->tagtransp($std);
        
        $std = new \stdClass();
        $std->item = 1;
        $std->qVol = 2;
        $std->esp = 'caixa';
        $std->marca = 'OLX';
        $std->nVol = '11111';
        $std->pesoL = 10.00;
        $std->pesoB = 11.00;
        $nfe->tagvol($std);
        
        $std = new \stdClass();
        $std->nFat = '002';
        $std->vOrig = 100;
        $std->vLiq = 100;
        $nfe->tagfat($std);
        
        $std = new \stdClass();
        $std->nDup = '001';
        $std->dVenc = date('Y-m-d');
        $std->vDup = 11.03;
        $nfe->tagdup($std);
        
        $std = new \stdClass();
        $std->vTroco = 0;
        $nfe->tagpag($std);
        
        $std = new \stdClass();
        $std->indPag = 0;
        $std->tPag = "01";
        $std->vPag = 10.99;
        $std->indPag=0;
        $nfe->tagdetPag($std);
        
        return $nfe->getXML(); // O conteúdo do XML fica armazenado na variável $xml
    }

    public function gerarNotaFiscal($notaFiscal){
        $this->notaFiscal = $notaFiscal;
        $this->carregarUtilitarios();
        /* MONTA O XML */
        $xml = $this->montarNFeNova(); 
        /* ASSINA O XML */
        $xml = $this->tools->signNFe($xml); 

        try{
          //  if (Validator::isValid($xml, "C:\projetos\ERPMobi\vendor\nfephp-org\nfephp\schemes\NFe\PL_008i2")) {
                $notaFiscal->xmlenvio = $xml;
                $retornoNFe = $this->enviar($xml);
                sleep(2);
                dd($retornoNFe);
                $notaFiscal->numerorecibo = $retornoNFe->infRec->nRec;
                $notaFiscal->NUMERONF = $this->parametroFiscal != null ? $this->parametroFiscal->numeroproximanotafiscal : 1;
                $retornoConsulta = $this->consultarRecibo($notaFiscal->numerorecibo);
                $this->eventoAposEnviarNotaFiscal($retornoConsulta);
                $notaFiscal->inserirRetorno($retornoConsulta);
                //$notaFiscal->save();
            // } else {
            //     return ['error' => $this->tools->errors];
            // }
        }
        catch(\Exception $ex){
            dd($ex);
            return $this->mensagemConexaoErro;
        }

        return $xml;
    }

    public function inutilizar($parametros){
        $resposta = array();
        $this->empresa = $this->sessionProperties->obterEmpresaBasico();
        $this->NFeTools->sefazInutiliza($this->obterNumeroSerie(), $parametros->numeroInicial, $parametros->numeroFinal,
            $parametros->justificativa, $this->empresa['idambiente'], $resposta);

        $this->salvarInutilizacao($parametros);

        return (object) $resposta;
    }

    private function salvarInutilizacao($parametros){
        // fazer o precesso
    }

    public function cancelar($notaFiscalCancelar){
        $resposta = array();
        $xJust = 'Cancelamento devido erro ao emitir';
        $this->empresa = $this->sessionProperties->obterEmpresaBasico();
        $retorno = $this->NFeTools->sefazCancela(
            $notaFiscalCancelar->chaveacesso,
            $this->empresa['idambiente'],
            $xJust,
            $notaFiscalCancelar->numeroprotocolo,
            $resposta
        );

        $notaFiscalCancelar->inserirRetornoCancelamento($resposta['evento'][0]);
        $notaFiscalCancelar->save();
        return (object) $resposta;
    }

    private function eventoAposEnviarNotaFiscal($retorno){
        if($this->parametroFiscal == null){
            $this->parametroFiscal = new ParametroFiscal();
            $this->parametroFiscal->idempresa = 1;
            $this->parametroFiscal->descricao = "Padrão";
            $this->parametroFiscal->numeroproximanotafiscal = 1;
            $this->parametroFiscal->numeroserie = 1;
            $this->parametroFiscal->save();
        }else{
            if($retorno->cStat == "100"){
                $this->parametroFiscal->numeroproximanotafiscal = $this->parametroFiscal->numeroproximanotafiscal + 1;
                $this->parametroFiscal->save();
            }
        }

    }

    public function gerar($id){
        $this->carregarUtilitarios($id);
        $nfe = $this->montarNFe();

        $xml = $this->assinarXML($nfe->getXML());
        try{
            if($this->validarXML($xml)){
                $retornoNFe = $this->enviar($nfe, $xml);
                sleep(2);
                $retornoConsulta = $this->consultarRecibo($retornoNFe->nRec);
            }else
                dd($this->NFeTools->errors);
        }
        catch(\Exception $ex){
            return $this->mensagemConexaoErro;
        }

        return $xml;
    }

    private function carregarUtilitarios($id = 35){
        if($this->empresa == null){
            $this->carregarNotaFiscal($id);
            $this->naturezaOperacao = FiscalNaturezaOperacao::where('id', 1)->first();
            $this->parametroFiscal = ParametroFiscal::where('idempresa', '1')->first();
            $this->carregarEmpresa();
            $this->carregarPessoa();
        }
    }

    private function carregarNotaFiscal($id){
        if($this->notaFiscal == null)
            $this->notaFiscal = NotaFiscal::where('id', $id)->first() ?: $this->obterNotaFiscalFake();
        else if($this->notaFiscal != null &&  $this->notaFiscalItens == null)
            $this->notaFiscal->itens = $this->notaFiscalItens = $this->notaFiscal->notaFiscalItens;
    }

    private function obterNotaFiscalFake(){
        $notaFiscal = new NotaFiscal();
        $notaFiscal->idempresa = $this->sessionProperties->obterEmpresaBasico()['id'];
        return $notaFiscal;
    }

    private function carregarEmpresa(){
        $this->empresa = $this->notaFiscal->Empresa;
        $this->empresaCidade = $this->empresa->Cidade;
        if($this->empresaCidade != null)
            $this->empresaEstado = $this->empresaCidade->Estado  ?: Estado::whereRaw("uf like '%sp%'")->first();
        else
            $this->empresaEstado = Estado::whereRaw("uf like '%sp%'")->first();
    }

    private function carregarPessoa(){
        $this->pessoa = $this->notaFiscal->Pessoa ?: Pessoa::whereRaw("razaosocial like '%". trim(explode("-", $this->viewModel['descricaoPessoa'])[1]) ."%'")->first();
        $this->pessoaCidade = $this->pessoa->Cidade ?: Cidade::whereRaw("descricao like '%". $this->pessoa->cidade ."%'")->first();
        $this->pessoaEstado = $this->pessoaCidade->Estado ?: Estado::whereRaw("uf like '%sp%'")->first();
    }

    public function gerarDANFE($id, $viewModel){
        $this->viewModel = $viewModel;
        $this->carregarUtilitarios($id);
        $resposta = array();
      //  $teste = $this->NFeTools->sefazConsultaChave($this->notaFiscal->chaveacesso, $this->empresa->idambiente, $resposta);
        $danfe = new Danfe($this->obterXMLParaVisualizar(), 'P', 'A4', $this->NFeTools->aConfig['aDocFormat']->pathLogoFile, 'I', '');
        $id = $danfe->montaDANFE();
        $danfe->printDANFE("{$id}-danfe.pdf", 'I');
    }

    public function downloadDANFE($id){
        $this->carregarUtilitarios($id);
        $resposta = array();
  //      $teste = $this->NFeTools->sefazDownload($this->notaFiscal->chaveacesso, $this->empresa->idambiente, $this->empresa->cnpj, $resposta);
        $danfe = new Danfe($this->obterXMLParaVisualizar(), 'P', 'A4', $this->NFeTools->aConfig['aDocFormat']->pathLogoFile, 'I', '');
        $id = $danfe->montaDANFE();
        $danfe->printDANFE("{$id}-danfe.pdf", 'D');
    }

    private function obterXMLParaVisualizar(){
        if($this->notaFiscal->numerorecibo && $this->notaFiscal->xmlenvio){
            $pathProtfile = $this->NFeTools->sefazConsultaChave($this->notaFiscal->chaveacesso, $this->empresa->idambiente, $resposta);
            $saveFile = true;
            $retorno = $this->NFeTools->addProtocolo($this->notaFiscal->xmlenvio, $pathProtfile, $saveFile);
            return $retorno;
        }else{
            $nfe = $this->montarNFe();
            return $this->assinarXML($nfe->getXML());
        }
    }

    public function enviar($xml){
        $idLote = str_pad(6, 15, '0', STR_PAD_LEFT);
        $resp = $this->tools->sefazEnviaLote([$xml], $idLote, 1);
        return (new Standardize)->toStd($resp);
    }

    public function consultarRecibo($numeroRecibo){
        $retorno = $this->tools->sefazConsultaRecibo($numeroRecibo, 2);
        return (new Standardize)->toStd($retorno);
    }

    public function consultarStatusServicoSEFAZ($idEmpresa){
        $aResposta = array();
        $empresa = $this->sessionProperties->obterEmpresaBasico($idEmpresa);
        $sigla = $empresa['cidade']['estado']['uf'] ?? "SP";

        try{
             $this->tools->model('55');
             $retornoXML = $this->tools->sefazStatus($sigla);
             $retorno = $this->standardize->toStd($retornoXML);
             return response()->json($retorno->xMotivo, 200);
        }
        catch(\Exception $ex){
            return $this->mensagemConexaoErro;
        }
    }

    private function montarNFe(){
        $nfe = new Make();
        $infNFe = $this->obterInfNFe($nfe);
        $ide = $this->obterIde($nfe);
        $emit = $this->obterEmit($nfe);
        // $enderEmit = $this->obterEnderEmit($nfe);
        // $dest = $this->obterDest($nfe);
        // $enderDest = $this->obterEnderDest($nfe);
        /* NÃO ALTERAR ORDEM */
        $infNFe->obterTag();
        $ide->obterTag();
        $emit->obterTag();
        $emit->obterTag();
        $enderEmit->obterTag();
        $dest->obterTag();
        $enderDest->obterTag();

        foreach ($this->obterProdutos() as $produto){
            $this->obterProd($nfe, $produto)->obterTag();

            //ICMS - Imposto sobre Circulação de Mercadorias e Serviços
            $icms = $this->obterICMS($nfe, $emit->getCRT(), $produto);
            $icms->obterTag();
            //IPI - Imposto sobre Produto Industrializado
            $ipi = $this->obterIPI($nfe, $produto);
            $ipi->obterTag();
            //PIS - Programa de Integração Social
            $pis = $this->obterPIS($nfe, $produto);
            $pis->obterTag();
            //COFINS - Contribuição para o Financiamento da Seguridade Social
            $cofins = $this->obterCOFINS($nfe, $produto);
            $cofins->obterTag();

            $imposto = $this->obterImposto($nfe, $produto, $icms, $ipi, $pis, $cofins)->obterTag();

            if(strlen($produto['cest']) > 0){
                $nfe->tagCEST($produto['nItem'], str_replace(".", "", $produto['cest']));
            }
            $this->produtoContador++;
        }

        //TOTAL
        $icmsTot = $this->obterICMSTot($nfe);

        $icmsTot->obterTag();
        //FRETE
        $this->obterTransp($nfe)->obterTag();
        //Informações Adicionais
        $this->obterInfAdic($nfe, $icmsTot)->obterTag();

        $nfe->getXML();

        return $nfe;
    }

    private function obterInfAdic($nfe, $icmsTotal){
        return new InfAdic($nfe, $icmsTotal);
    }

    private function obterInfNFe($nfe, &$ide){
        $std = new \stdClass();
        $std->versao = NfeConstant::VERSAO;
        $std->Id = null;
        $std->pk_nItem = '';
        $nfe->taginfNFe($std);
    }

    private function obterIde($nfe){
        $numeroAleatorio = CommonExtension::stringZero(mt_rand (1, 99999999), 8);
        $std->cUF = $this->empresaEstado->codigo; //coloque um código real e válido
        $std->cNF = $numeroAleatorio;
        $std->natOp = $this->obterNaturezaOperacaoDescricao($this->empresaEstado);
        $std->mod = NfeConstant::MODELO;
        $std->serie = $this->obterNumeroSerie();
        $std->nNF = $this->parametroFiscal != null ? $this->parametroFiscal->numeroproximanotafiscal : "1";
        $std->dhEmi = '2018-07-27T20:48:00-02:00';
        $std->dhSaiEnt = '2018-07-27T20:48:00-02:00';
        $std->tpNF = $this->naturezaOperacao->idfinanceiromovimentotipo - 1;
        $std->idDest = $this->obterOperacaoDestino();
        $std->cMunFG = $this->empresaCidade->codigo; //Código de município precisa ser válido
        $std->tpImp = $this->parametroFiscal != null ? ($this->parametroFiscal->idnotafiscalorientacaoimpressao == "" ? "1" : $this->parametroFiscal->idnotafiscalorientacaoimpressao) : "1";
        $std->tpEmis = NfeConstant::NFeNORMAL;
        $std->cDV = 2;
        $std->tpAmb = 2; // ambiente HOMOLOGAÇÃO
        $std->finNFe = ($this->naturezaOperacao->NaturezaOperacaoFinalidade ? $this->naturezaOperacao->NaturezaOperacaoFinalidade->id : 1);
        $std->indFinal = 1;
        $std->indPres = 9;
        $std->procEmi = '0';
        $std->verProc = 1;
        $nfe->tagide($std);
    }

    private function obterNumeroSerie(){
        return $this->parametroFiscal != null ? $this->parametroFiscal->numeroserie : "1";
    }

    private function obterOperacaoDestino(){
        return ($this->empresaEstado->codigo == $this->pessoaEstado->codigo) ? NfeConstant::OperacaoInterna : NfeConstant::OperacaoInterestadual;
    }

    private function obterNaturezaOperacaoDescricao($estadoEmpresa){
        $descricao = "";
        if($estadoEmpresa->codigo == $this->pessoaEstado->codigo)
            $descricao = $this->naturezaOperacao->FiscalCFOPDentroEstado->descricao;
        else
            $descricao = $this->naturezaOperacao->FiscalCFOPForaEstado->descricao;

        return mb_substr($descricao, 0, 59);
    }

    private function obterEmit($nfe){
        $std = new \stdClass();
        $std->xNome = $this->empresa->razaosocial;
        $std->xFant = $this->empresa->nomefantasia;
        $std->IE = ($this->empresa->inscricaoestadual);
        $std->IM = ($this->empresa->inscricaomunicipal ? $this->empresa->inscricaomunicipal : "");
        $std->CRT = $this->empresa->idfiscalregimetributario;
        $std->CNPJ = $this->empresa->cnpj;
        $nfe->tagemit($std);
    }

    private function obterEnderEmit($nfe){
        $enderecoEmitente = new EnderEmit($nfe);
        $enderecoEmitente->setXLgr($this->empresa->endereco);
        $enderecoEmitente->setNro($this->empresa->numero ? $this->empresa->numero :  "s/n");
        $enderecoEmitente->setXCpl($this->empresa->complemento ? $this->empresa->complemento : "");
        $enderecoEmitente->setXBairro($this->empresa->bairro);
        $enderecoEmitente->setCMun($this->empresaCidade->codigo);
        $enderecoEmitente->setXMun($this->empresaCidade->descricao);
        $enderecoEmitente->setUF(strtoupper($this->empresaEstado->uf));
        $enderecoEmitente->setCEP(CommonExtension::removerMascaraCEP($this->empresa->cep));
        $enderecoEmitente->setCPais(NfeConstant::CodigoBrasil);
        $enderecoEmitente->setXPais(NfeConstant::Brasil);
        $enderecoEmitente->setFone(CommonExtension::removerMascaraTelefone($this->empresa->telefone));
        return $enderecoEmitente;
    }

    private function obterDest($nfe){
        $dest = new Dest($nfe);
        if($this->pessoa->isPessoaJuridica()){
            $dest->setCNPJ(CommonExtension::removerCNPJ($this->pessoa->cpfoucnpj));
            $dest->setCPF("");
            $dest->setIE(CommonExtension::removerMascaraIE($this->pessoa->rgouinscricaoestadual));
            $dest->setIM($this->pessoa->inscricaomunicipal);
        }else{
            $dest->setCNPJ("");
            $dest->setCPF(CommonExtension::removerCNPJ($this->pessoa->cpfoucnpj));
            $dest->setIE("");
            $dest->setIM("");
        }

        $dest->setIdEstrangeiro(""); // Padrão por enquanto
        $dest->setXNome($this->pessoa->razaosocial);
        $contribuinteTipo = $this->pessoa->contribuinteTipo;
        $dest->setIndIEDest($contribuinteTipo != null ? $contribuinteTipo->codigo : "9");
        $dest->setISUF(""); // Padrão por enquanto
        $dest->setEmail($this->pessoa->email);
        return $dest;
    }

    private function obterEnderDest($nfe){
        $destEmitente = new EnderDest($nfe);
        $destEmitente->setXLgr($this->pessoa->endereco);
        $destEmitente->setNro($this->pessoa->numero ? $this->pessoa->numero : "s/n");
        $destEmitente->setXCpl($this->pessoa->complemento ? $this->pessoa->complemento : "");
        $destEmitente->setXBairro($this->pessoa->bairro);
        $destEmitente->setCMun($this->pessoaCidade->codigo);
        $destEmitente->setXMun($this->pessoaCidade->descricao);
        $destEmitente->setUF(strtoupper($this->pessoaEstado->uf));
        $destEmitente->setCEP(CommonExtension::removerMascaraCEP($this->pessoa->cep));
        $destEmitente->setCPais(NfeConstant::CodigoBrasil);
        $destEmitente->setXPais(NfeConstant::Brasil);
        $destEmitente->setFone(CommonExtension::removerMascaraTelefone($this->pessoa->telefone));
        return $destEmitente;
    }

    private function obterImposto($nfe, $prod, $icms, $ipi, $pis, $cofins){
        $imposto = new Imposto($nfe, $icms, $ipi, $pis, $cofins);
        $imposto->setnItem($prod['nItem']);
        $this->valorTotalTributos .= $imposto->getvTotTrib(); // 226.80 ICMS + 51.50 ICMSST + 50.40 IPI + 39.36 PIS + 81.84 CONFIS
        return $imposto;
    }

    private function obterICMS($nfe, $CRT, $produto){
        $icms = new ICMS($nfe, $CRT);
        $this->CRT = $CRT;
        $cstCSOSN = $this->produtoCSTCSOSN[$this->produtoContador];
        $csosnCodigo = $cstCSOSN != null ?  $this->produtoCSTCSOSN[$this->produtoContador]->codigo : "900";
        $icms->setNItem($produto['nItem']);
        $icms->setOrig("0");
        $icms->setModBC("3");
        $icms->setPRedBC("");
        $icms->setPICMS($produto['icms']);
        if((double)($produto['icms']) > 0){
            $icms->setVBC($produto['vProd']);
            $this->calcularValorTotalICMSBase($produto, $csosnCodigo);
            $icms->setVICMS($this->obterValorICMS($produto, $csosnCodigo));
        }else{
            $icms->setVBC("0.00");
            $icms->setVICMS("0.00");
        }

        $icms->setVICMSDeson("0.00");
        $icms->setMotDesICMS("");
        $icms->setModBCST("0");
        $icms->setPMVAST("");
        $icms->setPRedBCST("");
        $icms->setVBCST("0.00");
        $icms->setPICMSST("0.00");
        $icms->setVICMSST("0.00");
        $icms->setPDif("");
        $icms->setVICMSDif("");
        $icms->setVICMSOp("");
        $icms->setVBCSTRet("");
        $icms->setVICMSSTRet("");
        $icms->setCsosn($csosnCodigo);
        $icms->setCst("00");

        if($csosnCodigo == "101"){
            $calculo = $this->obterCalculoCSOSN($produto);
            $icms->setPCredSN($calculo->aliquota);
            $icms->setVCredICMSSN($calculo->vCredICMS);
        }else{
            $icms->setPCredSN("");
            $icms->setVCredICMSSN("");
        }

        return $icms;
    }

     private function calcularValorTotalICMSBase($produto, $csosnCodigo){
         if($csosnCodigo != "400" && $this->CRT != 1){
            $this->valorTotalICMSBaseCalculo .= $produto['vProd'];
        }
    }

    private function obterValorICMS($produto, $csosnCodigo){
        $calculo = (($produto['icms'] / 100) * $produto['vProd']);
        if($csosnCodigo != "400" && $this->CRT != 1)
            $this->valorTotalICMS .= number_format($calculo, 2, '.', '');

        return number_format($calculo, 2, '.', '');
    }

    private function obterCalculoCSOSN($produto){
        $aliquota = $this->empresa->aliquotasimplesnacional;
        $calculo = (($aliquota / 100) * $produto['vProd']);
        return (object) array(
            'aliquota' => $aliquota,
            'vCredICMS' => number_format($calculo, 2, '.', '')
        );
    }

    private function obterIPI($nfe, $produto){
        $ipi = new IPI($nfe);
        $ipi->setNItem($produto['nItem']);
        if($this->empresa->isSimplesNacional()){
            $ipi->setCst("99");
        }else{
            $ipi->setCst("00");
        }
        $ipi->setClEnq("");
        $ipi->setCnpjProd("");
        $ipi->setCSelo("");
        $ipi->setQSelo("");
        $ipi->setCEnq("999");
        $ipi->setVBC("0.00");
        $ipi->setPIPI("0.00");
        $ipi->setQUnid("");
        $ipi->setVUnid("");
        $ipi->setVIPI("0.00");
        return $ipi;
    }

    private function obterPIS($nfe, $produto){
        $pis = new PIS($nfe);
        $pis->setNItem($produto['nItem']);
        if($this->empresa->isSimplesNacional()){
            $pis->setCst("99");
            //$pis->setVAliqProd("0.00");
        }else{
            $pis->setCst("00");
            //$pis->setVAliqProd("0.00");
        }
        $pis->setVBC("0.00");
        $pis->setPPIS("0.00");
        $pis->setVPIS("0.00");
        //$pis->setQBCProd("0.00");
        return $pis;
    }

    private function obterCOFINS($nfe, $produto){
        $COFINS = new COFINS($nfe);
        $COFINS->setNItem($produto['nItem']);
        if($this->empresa->isSimplesNacional()){
            $COFINS->setCst("99");
            //$COFINS->setVAliqProd("0.00");
        }else{
            $COFINS->setCst("00");
            //$COFINS->setVAliqProd("0.00");
        }
        $COFINS->setVBC("0.00");
        $COFINS->setPCOFINS("0.00");
        $COFINS->setVCOFINS("0.00");
        // $COFINS->setQBCProd("0.00");

        return $COFINS;
    }

    private function obterICMSTot($nfe){
        $icmsTot = new ICMSTot($nfe);
        if($this->valorTotalICMSBaseCalculo > 0)
            $icmsTot->setVBC($this->valorTotalICMSBaseCalculo);
        else
            $icmsTot->setVBC("0.00");

        $icmsTot->setVICMS($this->valorTotalICMS > 0 ? $this->valorTotalICMS : "0.00");
        $icmsTot->setVICMSDeson("0.00");
        $icmsTot->setVBCST("0.00");
        $icmsTot->setVST("0.00");
        $icmsTot->setVProd($this->notaFiscal->valortotal + $this->valorTotalDesconto);
        $icmsTot->setVFrete("0.00");
        $icmsTot->setVSeg("0.00");
        $icmsTot->setVDesc($this->valorTotalDesconto);
        $icmsTot->setVII("0.00");
        $icmsTot->setVIPI("0.00");
        $icmsTot->setVPIS("0.00");
        $icmsTot->setVCOFINS("0.00");
        $icmsTot->setVOutro("0.00");
        $icmsTot->setVTotTrib($this->valorTotalTributos > 0 ? $this->valorTotalTributos : "0.00");

        return $icmsTot;
    }

    private function obterTransp($nfe){
        $transp = new Transp($nfe);
        $transp->setModFrete(0);
        return $transp;
    }

    private function obterProdutos(){
        $produtos = array();
        $id = 0;
        if($this->notaFiscalItens == null || $this->notaFiscalItens->count() == 0)
            $this->notaFiscal->itens = $this->notaFiscalItens = $this->notaFiscal->notaFiscalItens;

        $this->notaFiscalItens->each(function ($item, $key) use(&$produtos, &$id) {
            $this->produto = $produto = $item->produto;

            $this->produtoCSTCSOSN[] = $produto->cstICMS;

            $produtos[$key] = array(
                'nItem' => $item->id,
                'cProd' => $produto->id,
                'cEAN' => '', // 97899072659522
                'xProd' => $produto->id == 1 ? $item->produtonomegenerico : $produto->descricao,
                'NCM' => $produto->fiscalNCM != null ? $produto->fiscalNCM->descricao : "",
                'EXTIPI' => '',
                'CFOP' => $produto->idcfop,
                'uCom' =>  strtoupper($produto->unidadeMedida->descricaoreduzida),
                'qCom' => $item->quantidade,
                'vUnCom' => $item->valorunitario,
                'vProd' => ($item->valortotalitem + $item->valordesconto),
                'cEANTrib' => '',
                'uTrib' => strtoupper($produto->unidadeMedida->descricaoreduzida),
                'qTrib' => $item->quantidade,
                'vUnTrib' => $item->valorunitario,
                'vFrete' => '',
                'vSeg' => '',
                'vDesc' => $item->valordesconto == "0.00" ? "" : $item->valordesconto,
                'vOutro' => '',
                'indTot' => '1',
                'xPed' => $id++,
                'nItemPed' => '1',
                'nFCI' => '',
                'icms' => $produto['icms'],
                'cest' => $produto->idfiscalcest > 0 ? $produto->fiscalCEST->codigo : "");

                $this->valorTotalDesconto += (double) number_format($item->valordesconto, 2, '.', '');
            // $financeiroTipo = $item->financeiroTipo;
            // $venda[$this->chaveRelacaoParcela][$key]['financeirotipodescricao'] = CommonExtension::adicionarCodigoEDescricao($financeiroTipo);
        });

        return $produtos;
    }
    private function obterProd($nfe, $produto){
        $prod = new Prod($nfe);
        $prod->setNItem($produto['nItem']);
        $prod->setCProd($produto['cProd']);
        $prod->setCEAN($produto['cEAN']);
        $prod->setXProd($produto['xProd']);
        $prod->setNCM($produto['NCM']);
        $prod->setEXTIPI($produto['EXTIPI']);
        $prod->setCFOP($this->obterCFOPProduto($produto));
        $prod->setUCom($produto['uCom']);
        $prod->setQCom($produto['qCom']);
        $prod->setVUnCom($produto['vUnCom']);
        $prod->setVProd($produto['vProd']);
        $prod->setCEANTrib($produto['cEANTrib']);
        $prod->setUTrib($produto['uTrib']);
        $prod->setQTrib($produto['qTrib']);
        $prod->setVUnTrib($produto['vUnTrib']);
        $prod->setVFrete($produto['vFrete']);
        $prod->setVSeg($produto['vSeg']);
        $prod->setVDesc($produto['vDesc']);
        $prod->setVOutro($produto['vOutro']);
        $prod->setIndTot($produto['indTot']);
        $prod->setXPed($produto['xPed']);
        $prod->setNItemPed($produto['nItemPed']);
        $prod->setNFCI($produto['nFCI']);

        return $prod;
    }

    private function obterCFOPProduto($produto){
        if($produto['CFOP'] != null && $produto['CFOP'] > 0)
            return $produto['CFOP'];
        else if($this->empresa->idfiscalcfopdentroestado > 0 || $this->empresa->idfiscalcfopforaestado){
            if($this->empresaEstado->codigo == $this->pessoaEstado->codigo)
                return $this->empresa->idfiscalcfopdentroestado;
            else
                return $this->empresa->idfiscalcfopforaestado;
        }

        return 0;
    }

    private function validarXML(&$xml){
        return !(! $this->NFeTools->validarXml($xml) || sizeof($this->NFeTools->errors));
    }

    private function assinarXML($xml){
        return $this->NFeTools->assina($xml);
    }

    
    private function obterConfiguracaoJson(){
        return json_encode([
            "atualizacao" => "2016-11-03 18:01:21",
            "tpAmb" => 2,
            "razaosocial" => "Avicultura Brasil Americana Ltda - Me",
            "cnpj" => "02149743000153",
            "siglaUF" => "SP",
            "schemes" => "PL_009_V4",
            "versao" => '4.00',
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            "proxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]   
        ]);
    }

    // private function obterJsonConfig(){
    //     $empresa = $this->sessionProperties->obterEmpresaBasico(1);
    //     $caminho = App::environment() == "local" ?  "C:\/projetos\/ERPMobi\/NFe\/": "\/var\/www\/html\/NFe\/";
    //     return '{
    //             "atualizacao":"2016-02-02 08:01:21",
    //             "tpAmb":"'. ($empresa['idambiente'] ? $empresa['idambiente'] : 2) .'",
    //             "pathXmlUrlFileNFe":"nfe_ws3_mod55.xml",
    //             "pathXmlUrlFileCTe":"cte_ws1.xml",
    //             "pathXmlUrlFileMDFe":"mdfe_ws1.xml",
    //             "pathXmlUrlFileCLe":"cle_ws1.xml",
    //             "pathXmlUrlFileNFSe":"",
    //             "pathNFeFiles":"",
    //             "pathCTeFiles":"'. $caminho .'",
    //             "pathMDFeFiles":"'. $caminho .'",
    //             "pathCLeFiles":"'. $caminho .'",
    //             "pathNFSeFiles":"'. $caminho .'",
    //             "pathCertsFiles":"'. $caminho .'",
    //             "siteUrl":"http:\/\/myapp.local",
    //             "schemesNFe":"PL_008h2",
    //             "schemesCTe":"PL_CTE_104",
    //             "schemesMDFe":"MDFe_100",
    //             "schemesCLe":"CLe_100",
    //             "schemesNFSe":"",
    //             "razaosocial":"'. $empresa['razaosocial'] .'",
    //             "siglaUF":"SP",
    //             "cnpj":"'. $empresa['cnpj'] .'",
    //             "tokenIBPT":"AAAAAAA",
    //             "tokenNFCe":"GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
    //             "tokenNFCeId":"000002",
    //             "certPfxName":"'. CommonExtension::removerCNPJ($empresa['cnpj']) .'.pfx",
    //             "certPassword":"'. $empresa['senha'] .'",
    //             "certPhrase":"",
    //             "aDocFormat":{
    //                 "format":"P",
    //                 "paper":"A4",
    //                 "southpaw":"1",
    //                 "pathLogoFile":"\/var\/www\/html\/public\/assets\/image\/impressao\/'. Auth::user()->imagem .'.jpg",
    //                 "logoPosition":"L",
    //                 "font":"Times",
    //                 "printer":"hpteste"},
    //             "aMailConf":{
    //                 "mailAuth":"1",
    //                 "mailFrom":"roberto@myapp.local",
    //                 "mailSmtp":"smtp.myapp.local",
    //                 "mailUser":"roberto@myapp.local",
    //                 "mailPass":"heslo$",
    //                 "mailProtocol":"ssl",
    //                 "mailPort":"587",
    //                 "mailFromMail":null,
    //                 "mailFromName":null,
    //                 "mailReplayToMail":null,
    //                 "mailReplayToName":null,
    //                 "mailImapHost":null,
    //                 "mailImapPort":null,
    //                 "mailImapSecurity":null,
    //                 "mailImapNocerts":null,
    //                 "mailImapBox":null},
    //             "aProxyConf":{
    //                 "proxyIp":"",
    //                 "proxyPort":"",
    //                 "proxyUser":"",
    //                 "proxyPass":""}
    //             }';
    // }
}