<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value={{$id}}>
<div class="row">
    <div class="col-xs-3">
        <label>
            NAS COMPRAS? {!!Form::CheckBox('utilizacompra', true, $utilizacompra, array('class' => 'flat-red')) !!}
        </label>
    </div>
    <div class="col-xs-3">
        <label>
            NAS VENDAS? {!!Form::CheckBox('utilizavenda', true, $utilizavenda, array('class' => 'flat-red')) !!}
        </label>
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        {!!Form::label('descricao', 'Descrição'); !!}
        {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição', 'required' => 'required'));!!}
    </div>
    <div class="col-xs-2">
        {!!Form::label('descricao', 'Parcelas'); !!}
        {!!Form::number('numeroparcelas', $numeroparcelas, array('class' => 'form-control', 'required' => 'required'));!!}
    </div>
        
    <div class="col-xs-2">
        {!!Form::label('descricao', 'Recorrência'); !!}
        {!!Form::number('recorrencia', $recorrencia, array('class' => 'form-control', 'required' => 'required'));!!}
    </div>
    <div class="col-xs-2">
        {!!Form::label('descricao', '1ª Parcela'); !!}
        {!!Form::number('diaprimeiraparcela', $diaprimeiraparcela, array('class' => 'form-control', 'required' => 'required'));!!}
    </div>
</div>
