@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-9">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Dados Basicos</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-1">
                        {!!Form::label('codigo', 'Código'); !!}
                        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
                    </div>
                    <div class="col-xs-2" style="margin-top: 30px">
                        <label>
                            Ativo: {!!Form::CheckBox('ativo', $ativo, true, array('class' => 'flat-red')) !!}
                        </label>
                    </div>
                    <div class="col-xs-2" style="margin-top: 30px">
                        <label>
                            Compras: {!!Form::CheckBox('compras', true, $compras, array('class' => 'flat-red')) !!}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8">
                        {!!Form::label('descricao', 'Descrição'); !!}
                        {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('tipo', 'Tipo'); !!}
                        <select id="idfinanceiromovimentotipo" name="idfinanceiromovimentotipo" class="form-control select2" style="width: 100%;">
                            @foreach ($movimentotipos as $tipo)
                                <option value="{{$tipo->id}}" {{$idfinanceiromovimentotipo == $tipo->id ? 'selected' : ''}}>{{$tipo->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('tipo', 'Demonstrativo'); !!}
                        <select id="idfinanceirodemonstrativo" name="idfinanceirodemonstrativo" class="form-control select2" style="width: 100%;">
                            @foreach ($demonstrativos as $monstrativo)
                                <option value="{{$monstrativo->id}}" {{$idfinanceirodemonstrativo == $monstrativo->id ? 'selected' : ''}}>{{$monstrativo->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('descricao', 'CC Débito'); !!}
                        {!!Form::text('debito', $debito, array('class' => 'form-control', 'placeholder' => 'Digite CC Débito'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('descricao', 'CC Crédito'); !!}
                        {!!Form::text('credito', $credito, array('class' => 'form-control', 'placeholder' => 'Digite CC Débito'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@endpush