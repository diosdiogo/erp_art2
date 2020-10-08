<?php

namespace App\Helper\Arquivo;

use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Produto\Produto;
use Session;
use App\Extension\MapperExtension;
use App\Enums\Sessao\SessaoControllerEnum;
use App\Models\Sistema\ConfiguracaoPadrao\ConfiguracaoPadrao;
use App\Models\Sistema\Notificacao\Notificacao;
use App\Helper\Sessao\HelperDeSessao;
use App\Repositorio\Sistema\Venda\RepositorioDeVenda;
use App\Extension\CommonExtension;
use Posprint\Printers\Bematech;
use Posprint\Connectors\Serial;


class HelperDeImpressaoCupom
{
    public static $caracterPorColuna = 40; // 40 colunas por linha


    public static function teste($teste){
        $repositorioDeVenda = new RepositorioDeVenda();
        $venda = $repositorioDeVenda->obterParaCupomNaoFiscal(2);
        $pessoa = $venda->pessoa;
        $empresa = HelperDeSessao::get(SessaoControllerEnum::Empresa)[0];

        $connector = null;
        $connector = new Serial();
        $printer = new Bematech($connector);
        $printer->initialize();
        $printer->setBold();
        $printer->setAlign("C");
        $printer->text($empresa->razaosocial);
        $printer->setBold();
        $printer->lineFeed(1);
        $printer->setAlign("C");
        $printer->text("CNPJ:" . CommonExtension::formatarCNPJ($empresa->cnpj));
        $printer->lineFeed(1);
        $printer->setAlign("C");
        $printer->text("FONE:" .  $empresa->telefone);
        $printer->lineFeed(1);
        $printer->setBold();
        $printer->text("SEM VALOR FISCAL");
        $printer->setBold();
        $printer->lineFeed(1);
        $printer->text("________________________________________________");
        $printer->lineFeed(1);
        $printer->setAlign("");
        $printer->text(implode("\r\n", $teste));
        $printer->lineFeed(1);
        $printer->setAlign("R");
        $printer->setBold();
        $printer->text('Sub-total: '. CommonExtension::formatarParaMoeda($venda->vendaitens->sum('valortotal')) . "         ");
        $printer->setBold();
        $printer->lineFeed(1);
        $printer->setAlign("L");
        $printer->text("________________________________________________");
        $printer->lineFeed(1);
        $printer->text("  COD:" . CommonExtension::stringZero($pessoa['id']));
        $printer->lineFeed(1);
        $printer->text('  CPF/CNPJ:'. $pessoa['cpfoucnpj']);
        $printer->lineFeed(1);
        $printer->text('  CLIENTE: '. $venda['nomepessoa']);
        $printer->cut();
        $printer->send();
    }

    public static function imprimir(){
        $repositorioDeVenda = new RepositorioDeVenda();
        $venda = $repositorioDeVenda->obterParaCupomNaoFiscal(2);
        $pessoa = $venda->pessoa;
        $empresa = HelperDeSessao::get(SessaoControllerEnum::Empresa)[0];
        $txt_cabecalho = array();
        $vendaItens = array();
        $txt_valor_total = '';
        $txt_rodape = array();
        $txt_cabecalho[] = $empresa->razaosocial; 
        $txt_cabecalho[] = CommonExtension::formatarCNPJ($empresa->cnpj);
        $txt_cabecalho[] = ' '; // força pular uma linha entre o cabeçalho e os itens
        $txt_cabecalho[] = '________________________________________';
        $txt_cabecalho[] = 'PRODUTOS';
        $vendaItens[] = array('  Produto', 'Qtd', 'V. UN', 'Total');
    	$tot_itens = 0;
        
        $venda->vendaitens->each(function ($item, $key) use(&$vendaItens) {
        	$vendaItens[] = array("  " . $item->descricao, $item->quantidade. ' x ', CommonExtension::formatarParaMoeda($item->valorunitario), CommonExtension::formatarParaMoeda($item->valortotal));
        });
        
        $aux_valor_total = 'Sub-total: '. CommonExtension::formatarParaMoeda($venda->vendaitens->sum('valortotal'));
        $total_espacos = HelperDeImpressaoCupom::$caracterPorColuna - strlen($aux_valor_total);
        
        $espacos = '';
        
        for($i = 0; $i < $total_espacos; $i++){ $espacos .= ' '; }
        
        $txt_valor_total = $espacos.$aux_valor_total;

        foreach ($vendaItens as $item) {
            $itens[] = HelperDeImpressaoCupom::addEspacos($item[0], 10, 'F')
                    . HelperDeImpressaoCupom::addEspacos($item[1], 10, 'I')
                    . HelperDeImpressaoCupom::addEspacos($item[2], 10, 'I')
                    . HelperDeImpressaoCupom::addEspacos($item[3], 12, 'I');
        }
        
        //HelperDeImpressaoCupom::teste($itens);
        return "";
    }

    

      public static function centraliza($info)
      {
            $aux = strlen($info);
            
            if ($aux < HelperDeImpressaoCupom::$caracterPorColuna) {
                // calcula quantos espaços devem ser adicionados
                // antes da string para deixa-la centralizada
                $espacos = floor((HelperDeImpressaoCupom::$caracterPorColuna - $aux) / 2);
                
                $espaco = '';
                for ($i = 0; $i < $espacos; $i++){
                    $espaco .= ' ';
                }
                
                // retorna a string com os espaços necessários para centraliza-la
                return $espaco.$info;
                
            } else {
                // se for maior ou igual ao número de colunas
                // retorna a string cortada com o número máximo de colunas.
                return substr($info, 0, HelperDeImpressaoCupom::$caracterPorColuna);
            }
            
        }

        /**
         * Adiciona a quantidade de espaços informados na String
         * passada na possição informada.
         * 
         * Se a string informada for maior que a quantidade de posições
         * informada, então corta a string para ela ter a quantidade
         * de caracteres exata das posições.
         * 
         * @param string $string String a ter os espaços adicionados.
         * @param int $posicoes Qtde de posições da coluna
         * @param string $onde Onde será adicionar os espaços. I (inicio) ou F (final).
         * @return string
         */
        public static function addEspacos($string, $posicoes, $onde)
        {
            $aux = strlen($string);
            
            if ($aux >= $posicoes)
                return substr ($string, 0, $posicoes);
            
            $dif = $posicoes - $aux;
            
            $espacos = '';
            
            for($i = 0; $i < $dif; $i++) {
                $espacos .= ' ';
            }
            
            if ($onde === 'I')
                return $espacos.$string;
            else
                return $string.$espacos;
            
        }        
}