<input type="text" id="idformarecebimentohidden" name="idformarecebimentohidden" value="{{$idformarecebimento}}" hidden>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">CONDIÇÕES DE PAGAMENTO</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-refresh"></i> ATUALIZAR (F8)</button>
                </div>
            </div>
            <div class="box-body">
                <div class="callout callout-warning" id="alertaFormaRecebimentoCliente" style="display: none">
                
                <h4><i class="icon fa fa-warning"></i> Atenção!</h4>

                <p>O melhor dia da semana para o cliente receber é : <span id="diaSemanaDescricao"> </span></p>
              </div>
                <div class="col-xs-6">
                    {!!Form::label('ufs', 'Forma de recebimento (F6)'); !!}
                    <select class="form-control select2" id="idformarecebimento" name="idformarecebimento" style="width: 100%;">
                        <option value="">[SELECIONE]</option>
                        @foreach ($financeiroformarecebimentos as $financeiroformarecebimento)
                        <option value="{{$financeiroformarecebimento->id}}" {{$idformarecebimento == $financeiroformarecebimento->id ? 'selected' : ''}}>{{$financeiroformarecebimento->id .' - '. $financeiroformarecebimento->descricao}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xs-6">
                    {!!Form::label('ufs', 'Parcelamento (F7)'); !!}
                    <input type="text" id="idformarecebimentoitemhidden" name="idformarecebimentoitemhidden" value="{{$idformarecebimentoitem}}" hidden>
                    <select class="form-control select2" name="idformarecebimentoitem" style="width: 100%;">
                    </select>
                </div>   
                <div class="col-xs-12" style="margin-top:10px; margin-bottom:10px">
                    <table id="griditemparcela" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="30px">#</th>
                                <th>VENCIMENTO</th>
                                <th width="250px">ESPÉCIE</th>                                
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tr>
                            <tbody>
                            </tbody>
                        </tr>
                    </table>
                 </div>    
                <div class="col-xs-3">
                    {!!Form::label('codigo', 'Valor total'); !!}
                    {!!Form::text('valortotalparcela', $valortotalparcela, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                </div>
                <div class="col-xs-3">
                    {!!Form::label('codigo', 'Diferença do pedido'); !!}
                    {!!Form::text('diferencia', $diferencia, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                </div>                
            </div>
        </div>
    </div>
</div>
