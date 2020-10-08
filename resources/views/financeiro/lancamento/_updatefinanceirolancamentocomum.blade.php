<div class="row">
    <div class="col-xs-4">
        {!!Form::label('codigo', 'Classificação'); !!}
        <select id="idfinanceirocontagerencial" name="idfinanceirocontagerencial" class="form-control select2" style="width: 100%;">
            @foreach ($financeirocontagerenciais as $tipo)
                <option value="{{$tipo->id}}" {{$idfinanceirocontagerencial == $tipo->id ? 'selected' : ''}}>{{$tipo->descricao}}</option>
            @endforeach
        </select>
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
        {!!Form::label('codigo', 'Data'); !!}
        {!!Form::date('datalancamento', $datalancamento, array('class' => 'form-control'));!!}
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
    <div class="col-xs-8">
        {!!Form::label('tipo', 'Observaçãoo'); !!}<br>
        {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}
    </div>
</div>