    {{-- <div class="col-md-8">
        <div class="box box-widget widget-user-2">
        <div class="widget-user-header bg-red">
            <div class="widget-user-image">
        </div>
            <center><h2 style="color:white" ><i class="fa fa-money"></i> <strong>VENCIDA</strong></h2></center>
    </div> --}}
        <div class="row">
            <div class="col-xs-4">
                {!!Form::label('produto_label', 'Conta'); !!}
                <select id="numerodocumento" name="numerodocumento" data-placeholder="SELECIONE codigo ou descrição" class="form-control select2" style="width: 100%;">
                    @if($descricaoDocumento)
                        <option value="{{$numerodocumento}}">{{$descricaoDocumento}}</option>
                    @endif;
                </select>
            </div>    
        </div>
        <div class="row">
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Data do recebimento'); !!}
                    {!!Form::date('datalancamento', $datalancamento, array('class' => 'form-control'));!!}
                </div>
            </div>
           <div class="row">
                <div class="col-xs-4">
                    {!!Form::label('tipo', 'Conta corrente'); !!}
                    <select id="idfinanceirocontaorigem" name="idfinanceirocontaorigem" class="form-control select2" style="width: 100%;">
                        @foreach ($financeirocontas as $conta)
                            <option value="{{$conta->id}}" {{$idfinanceirocontaorigem == $conta->id ? 'selected' : ''}}>{{$conta->descricao}}</option>
                        @endforeach
                    </select>
                </div>               
            </div>
            <div class="row">
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Juros'); !!}
                    {!!Form::text('jurosmoeda', $jurosmoeda, array('class' => 'form-control money'));!!}
                </div>
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Valor total (R$)'); !!}
                    {!!Form::text('valortotalconta', $valortotalreceber, array('class' => 'form-control money', 'disabled' => 'disabled'));!!}                    
                </div> 
            </div>
            <div class="row">
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Desconto'); !!}
                    {!!Form::text('descontomoeda', $descontomoeda, array('class' => 'form-control money'));!!}
                </div>
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Troco (R$)'); !!}
                    {!!Form::text('valortroco', '0,00', array('class' => 'form-control money', 'disabled' => 'disabled'));!!}                    
                </div>                 
            </div>
            <div class="row">
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Valor'); !!}
                    {!!Form::text('valor', $valor, array('class' => 'form-control money'));!!}
                </div>
                <div class="col-xs-1">
                    <button id="btnAtualizar" style="margin-top:25px" type="button" class="btn btn-primary form-control"><i class="fa fa-refresh"></i></button>
                </div>
                <div class="col-xs-3">
                </div>
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'A Receber (R$)'); !!}
                    {!!Form::text('valorareceber', '0,00', array('class' => 'form-control money', 'disabled' => 'disabled'));!!}                    
                </div>                
            </div>
            <div class="row">
                <div class="col-xs-4">
                    {!!Form::label('tipo', 'Efetuado em'); !!}
                    <select id="idfinanceiroformarecebimento" name="idfinanceiroformarecebimento" class="form-control select2" style="width: 100%;">
                        @foreach ($financeiroformarecebimentos as $recebimento)
                            <option value="{{$recebimento->id}}" {{$idfinanceiroformarecebimento == $recebimento->id ? 'selected' : ''}}>{{$recebimento->descricao}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    {!!Form::label('codigo', 'Data vencimento'); !!}
                    {!!Form::date('datavencimento', $datavencimento, array('class' => 'form-control', 'disabled' => 'disabled'));!!}                 
                </div>                 
            </div>
            </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    {!!Form::label('tipo', 'Observação'); !!}<br>
                    {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}
                </div>
            </div>
            </ul>
        </div>
        </div>
    </div>
</div>

<script>
    $.namespace("updatefinanceirolancamentocontareceber", function(){
        var publico = {};


        publico.init = function(){
            $("input[name='valor']").on('change', recalcularValores);
            $("#btnAtualizar").on("click", recalcularValores);

            updatetemplatejs.comboBoxSelect("numerodocumento", "/financeirolancamento/obterdocumento", function(){
                return { id : $("#idfinanceirolancamentotipo").val()  }
            });
        }

        var recalcularValores = function(){
            var url = "/financeirolancamento/recalcularvalores";

            var parametro = {
                jurosmoeda : $("input[name='jurosmoeda']").val(),
                descontomoeda : $("input[name='descontomoeda']").val(),
                valor : $("input[name='valor']").val(),
            };

            $.get(url, parametro, function(data){
                    $("input[name='valortotalconta']").val($.toMoney(data.valorTotal));
                    $("input[name='valortroco']").val($.toMoney(data.valortroco));
                    $("input[name='valorareceber']").val($.toMoney(data.valorareceber));
            });
        }

        return publico;
    });

    $(function(){
        $.namespace("updatefinanceirolancamentocontareceber").init(); 
    });    
</script>