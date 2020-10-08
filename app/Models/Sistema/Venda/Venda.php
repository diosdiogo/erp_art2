<?php

namespace App\Models\Sistema\Venda;

use App\Models\BaseModel;
use App\Enums\VendaSituacaoEnum;
use App\Helper\SessionProperties;
use App\Extension\MapperExtension;
use App\Models\Sistema\Pessoa\Pessoa;
use App\Models\Sistema\Venda\VendaItem;
use App\Models\Sistema\Venda\VendaSituacao;
use App\Models\Sistema\Transportadora\Transportadora;
use App\Models\Sistema\Venda\VendaFormaRecebimentoParcela;
use App\Models\Sistema\Financeiro\FormaRecebimento\FinanceiroFormaRecebimento;

class Venda extends BaseModel
{
    protected $fillable = ['idempresa', 'orcamento', 'datavenda', 'dataentrega', 'idtransportadora', 'idpessoa', 'idpessoavendedor', 'idformarecebimento', 'idformarecebimentoitem','observacao', 'valortotal',
    'descricaorelatorio', 'valortroco' /*'acrescimomoeda',
    'descontomoeda', */];
    protected $sessionProperties;

    public function __construct()
    {
        parent::__construct();
        $this->sessionProperties = new SessionProperties();
    }

   public function vendaitens(){
        return $this->hasMany(VendaItem::class, "idvenda");
    }

    public function alterarSituacaoParaVendaConcluida(){
        $this->vendaitens->each(function ($item, $key) use (&$venda) {
            $produto = $item->produto;
            if($produto->contabilizaestoque){
                $produto->baixarEstoque($item->quantidade, $item->quantidadepeca);
                $produto->save();
            }
        });


        return $this->attributes['idvendasituacao'] = VendaSituacaoEnum::CONCLUIDA;
    }

    public function transportadora(){
        return $this->belongsTo(Transportadora::class, 'idtransportadora');
    }

    public function pessoa(){
        return $this->belongsTo(Pessoa::class, 'idpessoa');
    }

    public function formaRecebimento(){
        return $this->belongsTo(FinanceiroFormaRecebimento::class, 'idformarecebimento');
    }

   public function parcelaitens(){
        return $this->hasMany(VendaFormaRecebimentoParcela::class, "idvenda");
    }

    private function validarGeral($alterar = false){
        $validacaoGenerica = [
            'datavenda' => 'required',
            'dataentrega' => 'required',
            'idtransportadora' => 'required',
            'observacao' => 'required',
            'idpessoa' => 'required',
            'vendaitens' => 'required|min:1',
            'datavenda' => 'after:yesterday',
            'dataentrega' => 'after:yesterday',
            'parcelaitens.*.datavencimento' => 'after:yesterday',
            'valorTotalJaRecebido' => 'not_in:0'];

        if(!$this->sessionProperties->isEmpresaFrigorifico()){
            $validacaoGenerica = MapperExtension::mapear($validacaoGenerica, [
                'idformarecebimento' => 'required',
                'idformarecebimentoitem' => 'required',
            ]);
        }

        return $validacaoGenerica;
    }

    public function validarInserir(){
        return $this->validarGeral();
    }

    public function validarAlterar(){
        return $this->validarGeral();
    }

    public $mensagemAlias = [
        'parcelaitens.*.after'=> 'O campo data vencimento da parcela deverá conter uma data igual ou posterior a hoje.',
        'datavenda.after' => 'O campo [Data venda] deverá conter uma data igual ou posterior a hoje.',
        'dataentrega.after' => 'O campo [Data entrega] deverá conter uma data igual ou posterior a hoje.',
        'idvendasituacao.not_in' => 'Não é possivel alterar/deletar/fatura uma venda já concluida.',
        'valorTotalJaRecebido.not_in' => 'Não é possivel salvar o pedido com o valor das parcelas diferente do valor total.'
    ];


    public function validarAntesDeDeletar(){
        return [
            'idvendasituacao' => "not_in:2"
        ];
    }

    public function validarFaturar(){
        return ['idvendasituacao' => 'not_in:2'];
    }

    public function validarAntesDeAlterar(){
        return [
            'idvendasituacao' => 'not_in:2'
        ];
    }

    public function validarReabrir(){
        return [
          'idvendasituacao' => 'not_in:1'
      ];
    }

    public function validarAlias(){
        return [
            'datavenda' => 'Data venda',
            'dataentrega' => 'Data entrega',
            'idtransportadora' => 'Transportadora',
            'idformarecebimento' => 'Forma de recebimento',
            'idformarecebimentoitem' => 'Parcelamento',
            'observacao' => 'Observação',
            'vendaitens' => 'Itens',
            'idpessoa' => 'Pessoa',
            'idvendasituacao' => '[situação] deve ser [aberta] por isso ',
        ];
    }

    public function isSituacaoConcluida(){
        return $this->attributes['idvendasituacao'] == VendaSituacaoEnum::CONCLUIDA;
    }

    public function alterarSituacaoParaVendaAberta(){
        if($this->isSituacaoConcluida()){
            $this->vendaitens->each(function ($item, $key) use (&$venda) {
                $produto = $item->produto;
                if($produto->contabilizaestoque){
                    $produto->devolverEstoque($item->quantidade, $item->quantidadepeca);
                    $produto->save();
                }
            });

            return $this->attributes['idvendasituacao'] = VendaSituacaoEnum::ABERTA;
        }
    }
}
