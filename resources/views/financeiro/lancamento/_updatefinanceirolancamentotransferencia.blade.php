<div class="row">
    <div class="col-xs-4">
        {!!Form::label('codigo', 'Data'); !!}
        {!!Form::date('datalancamento', $datalancamento, array('class' => 'form-control'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        {!!Form::label('tipo', 'Conta corrente de origem'); !!}
        <select id="idfinanceirocontaorigem" name="idfinanceirocontaorigem" class="form-control select2" style="width: 100%;">
            @foreach ($financeirocontas as $conta)
                <option value="{{$conta->id}}" {{$idfinanceirocontaorigem == $conta->id ? 'selected' : ''}}>{{$conta->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        {!!Form::label('tipo', 'Conta corrente de destino'); !!}
        <select id="idfinanceirocontadestino" name="idfinanceirocontadestino" class="form-control select2" style="width: 100%;">
            @foreach ($financeirocontas as $conta)
                <option value="{{$conta->id}}" {{$idfinanceirocontadestino == $conta->id ? 'selected' : ''}}>{{$conta->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        {!!Form::label('codigo', 'Numero documento'); !!}
        {!!Form::text('numerodocumento', $numerodocumento, array('class' => 'form-control'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-4">
        {!!Form::label('codigo', 'Valor'); !!}
        {!!Form::text('valor', $valor, array('class' => 'form-control money'));!!}
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
</div>              
<div class="row">
    <div class="col-xs-12">
        {!!Form::label('tipo', 'Observação'); !!}<br>
        {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}
    </div>
</div>