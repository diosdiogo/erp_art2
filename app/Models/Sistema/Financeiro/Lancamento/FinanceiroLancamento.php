<?php
namespace App\Models\Sistema\Financeiro\Lancamento;

use App\Models\BaseModel;
use App\Enums\FinanceiroContaGerencialEnum;
use App\Enums\FinanceiroLancamentoTipoEnum;
use App\Enums\FinanceiroContaFinanceiraEnum;
use App\Enums\FinanceiroLancamentoDocumentoTipoEnum;
use App\Enums\FinanceiroLancamentoTipoLancamentoTipoEnum;
use App\Models\Sistema\Financeiro\ContaPagar\FinanceiroContaPagar;
use App\Models\Sistema\Financeiro\ContaReceber\FinanceiroContaReceber;
use App\Models\Sistema\Financeiro\Lancamento\FinanceiroLancamentoDocumentoTipo;

class FinanceiroLancamento extends BaseModel
{
    protected $fillable = array('idempresa', 'observacao', 'datalancamento', 'valor',
                                'idlancamentotipolancamento',  'idfinanceirolancamentotipo', 'idfinanceirocontagerencial',
                                'idfinanceiroformarecebimento', 'numerodocumento', 'idfinanceirocontadestino', 'idfinanceirocontaorigem',
                                'jurosmoeda', 'descontomoeda', 'idfinanceirodocumentotipo', 'idfinanceiroconta');
    /* VALIDAÇÃO */
    public function validarInserir(){
        return [
            'observacao' => 'required|max:100',
            'valor' => 'required',
        ];
    }

   public function financeiroContaReceber()
   {
       return FinanceiroContaReceber::where('id', '=', $this->attributes['numerodocumento'])->first();
   }

   public function financeiroContaPagar()
   {
       return FinanceiroContaPagar::where('id', '=', $this->attributes['numerodocumento'])->first();
   }

    public function validarAlias(){
        return [
            'observacao' => 'Observacao',
        ];
    }

    public $mensagemAlias = [
        'idlancamentotipolancamento.not_in' => 'Não é possivel alterar ou deletar lançamentos automáticos'
    ]; 

    public function validarAntesDeAlterar(){
        $automatico = FinanceiroLancamentoTipoLancamentoTipoEnum::AUTOMATICO;

        return [
            'idlancamentotipolancamento' => "not_in:$automatico" 
        ];
    }

    public function validarAntesDeDeletar(){
        $automatico = FinanceiroLancamentoTipoLancamentoTipoEnum::AUTOMATICO;

        return [
            'idlancamentotipolancamento' => "not_in:$automatico" 
        ];
    }
    
    /* VALIDAÇÃO */

    /* HERANÇA */

     public function financeiroDocumentoTipo(){
        return $this->belongsTo(FinanceiroLancamentoDocumentoTipo::class, 'idfinanceirodocumentotipo');
    }

    /* HERANÇA */

    /* REGRAS */

    public function alterarDocumentoTipoPadrao(){
        return $this->attributes['idfinanceirodocumentotipo'] = FinanceiroLancamentoDocumentoTipoEnum::PADRAO;
    }

    public function alterarDocumentoTipoVenda(){
        return $this->attributes['idfinanceirodocumentotipo'] = FinanceiroLancamentoDocumentoTipoEnum::VENDA;
    }

    public function alterarDocumentoTipoNFe(){
        return $this->attributes['idfinanceirodocumentotipo'] = FinanceiroLancamentoDocumentoTipoEnum::NF;
    }

    public function alterarFinanceiroContaGerencialVenda(){
        return $this->attributes['idfinanceirocontagerencial'] = FinanceiroContaGerencialEnum::VENDA;
    }

    public function alterarAlterarLancamentoTipoLancamentoAutomatico(){
        return $this->attributes['idlancamentotipolancamento'] = FinanceiroLancamentoTipoLancamentoTipoEnum::AUTOMATICO;
    }

    public function alterarAlterarLancamentoTipoRecebimento(){
        return $this->attributes['idfinanceirolancamentotipo'] = FinanceiroLancamentoTipoEnum::RECEBIMENTO;
    }

    public function alterarAlterarContaOrigem(){
        return $this->attributes['idfinanceirocontaorigem'] = FinanceiroContaFinanceiraEnum::CAIXA;
    }

    public function obterParaVenda(){
        $this->alterarDocumentoTipoVenda();
        $this->alterarAlterarLancamentoTipoLancamentoAutomatico();
        $this->alterarFinanceiroContaGerencialVenda(); 
        $this->alterarAlterarLancamentoTipoRecebimento();
        $this->alterarAlterarContaOrigem();
    }

    /* REGRAS */
}