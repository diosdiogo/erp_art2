<?php
namespace App\Servico\Sistema\Financeiro\FormaRecebimento;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Extension\CommonExtension;
use App\Http\Controllers\Behavior\GridUpdateBaseController;
use App\Models\Sistema\Parametro\Faturamento\ParametroFaturamento;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimentoItem;
use App\Models\Sistema\Financeiro\FormaRecebimento\Tipo\FinanceiroFormaRecebimentoTipo;

class ServicoDeFinanceiroFormaRecebimento
{
    protected $parcelaitens = "parcelaitens";
    protected $gridUpdateBaseController;
    protected $idFormaRecebimentoItem = "idformarecebimentoitem";
    protected $idFormaRecebimento = "idformarecebimento";
    protected $parametroFaturamento;
    protected $tipo;
    public function __construct($gridUpdateBaseController)
    {
        $this->gridUpdateBaseController = $gridUpdateBaseController;
        $this->parametroFaturamento = ParametroFaturamento::first();
    }

    public function gerarFormaDeRecebimento(Request $request, $valorTotalVenda){
        $carbonDataAtual = Carbon::now();
        $this->gridUpdateBaseController->removerTodos($this->parcelaitens);
        $idformarecebimentoitem = $request[$this->idFormaRecebimentoItem];
        $idformarecebimento = $request[$this->idFormaRecebimento];

         if($request != null && $idformarecebimentoitem != null &&  $idformarecebimento != null){
             $formaRecebimentoItem = FinanceiroFormaRecebimentoItem::where('id', '=', $idformarecebimentoitem)->where($this->idFormaRecebimento, '=', $idformarecebimento)->first();
             $this->tipo = $formaRecebimentoItem->FormaRecebimento->Tipo;
            if($formaRecebimentoItem != null){
                $numeroDeParcelas = $formaRecebimentoItem->numeroparcelas == 0 ? 1 : $formaRecebimentoItem->numeroparcelas;
                $diaprimeiraparcela = $formaRecebimentoItem->diaprimeiraparcela;

                for($parcela = 1; $parcela <= $numeroDeParcelas; $parcela++){
                    $quantidadeDiasRecorrente = $parcela == 1 ? $diaprimeiraparcela : $formaRecebimentoItem->recorrencia;
                    $carbonDataAtual->addDay($quantidadeDiasRecorrente);
                    $this->gridUpdateBaseController->adicionar($this->parcelaitens, $this->obterViewModelParcelaItem($carbonDataAtual,$parcela, $numeroDeParcelas, $valorTotalVenda));
                }
            }
        }
    }

    public function obterViewModelParcelaItem($carbonDataAtual, $parcela, $numeroDeParcelas, $valorTotalVenda){
        return [
                'id' => $parcela,
                'parcela' => $parcela . "/" . $numeroDeParcelas ,
                'datavencimento' => CommonExtension::formatarData($carbonDataAtual, 'Y-m-d'),
                'valor'=> (($valorTotalVenda / $numeroDeParcelas)),
                'idfinanceirotipo' => $this->tipo != null ? $this->tipo->id :  ($parcela == 1 ? '1' : '3'),
                'financeirotipodescricao' => $this->tipo != null ? CommonExtension::adicionarCodigoEDescricao($this->tipo) : ($parcela == 1 ? '1 - DINHEIRO' : '3 - CREDITO')
        ];
    }

    public function obterPrimeiraParcela(){
        return (object) $this->gridUpdateBaseController->updateViewModel()->get($this->parcelaitens)->first(function ($item, $key) {
            return starts_with($key['parcela'], "1/");
        });
    }

    public function obterOutrasParcelas(){
        return $this->gridUpdateBaseController->updateViewModel()->get($this->parcelaitens)->reject(function ($item) {
            return starts_with($item['parcela'], "1/");
        });
    }


   public function recalcularParcelas($viewModel, $valorTotal){
        if($this->parametroFaturamento == null || $this->parametroFaturamento->recalcularformarecebimento){
            $primeiraParcela = $this->obterPrimeiraParcela();
            $outrasParcelas = $this->obterOutrasParcelas();

            $quantidadeParcela = $outrasParcelas->count();
            if($primeiraParcela != null && $primeiraParcela->parcela == $viewModel['parcela'] && $quantidadeParcela > 0){
                $valorDividir = str_replace(",", ".", str_replace(".", "", $valorTotal)) - $primeiraParcela->valor;
                $valorDividir = $valorDividir <= 0 ? 0 : $valorDividir;

                $teste = "";
                $outrasParcelas->each(function ($item, $key) use(&$teste, $quantidadeParcela, $valorDividir) {
                    $item['valor'] = $valorDividir <= 0 ? 0 : ($valorDividir / $quantidadeParcela);
                    $this->alterarValorParcela($item);
                    $teste .= ('PARCELA: '. $item['parcela'] . " | VALOR PARCELA: " . $item['valor'] .'  =  ');
                });
            }
        }
    }


    public function obterValorTotalParcelas(){
        $collection = collect($this->gridUpdateBaseController->updateViewModel()->get($this->parcelaitens))->map(function ($item) {
            $item['valor'] = CommonExtension::removerVirgulaPorPonto($item['valor']);
            return $item;
        });

        return $collection != null ? $collection->sum('valor') : 0;
    }

    public function calcularDiferencaParcelas($valorTotal, $valorTotalParcela){
        $valor = (float)$valorTotal - (float)$valorTotalParcela;
        $valorArredondado = round($valor, 2);
        $diferenca = number_format($valorArredondado, 2);

        return [
            'diferencia' => $diferenca,
            'valortotalparcela' => $valorTotalParcela
        ];
    }

    public function obterParcelas(){
        return $this->gridUpdateBaseController->updateViewModel()->get($this->parcelaitens);
    }

    public function alterarValorParcela($viewModel, $viewModelTela = null, $dataParcela = false){
        if($dataParcela){
            $item = $this->gridUpdateBaseController->obterUpdateViewModelItem($this->obterParcelas(), $viewModel);
            $this->gridUpdateBaseController->remover($this->parcelaitens, $viewModel['parcela'], 'parcela');
            $item['datavencimento'] = $viewModel['datavencimento'];
            $this->gridUpdateBaseController->adicionar($this->parcelaitens, $item);
        }else{
            $this->gridUpdateBaseController->remover($this->parcelaitens, $viewModel['parcela'], 'parcela');

            if(starts_with($viewModel['parcela'], "1/") && ($viewModelTela == null || count($this->parcelaitens) == 1)){
                $viewModel['valor'] = CommonExtension::formatarTextoParaDecimal($viewModel['valor']);
            }

            $idfinanceirotipo = $viewModel['idfinanceirotipo'] != null ? $viewModel['idfinanceirotipo'] : 1;
            $viewModel['financeirotipodescricao'] = CommonExtension::adicionarCodigoEDescricao(FinanceiroFormaRecebimentoTipo::where('id', $idfinanceirotipo)->first());
            $this->gridUpdateBaseController->adicionar($this->parcelaitens, $viewModel);
        }
    }
}