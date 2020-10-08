@extends('template/updatetemplate')

@section('contentInteno')
<input name="descricao" value="Parametro Fiscal" type="hidden">
<div class="row">
     <div class="col-xs-1">
        {!!Form::label('codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Configuração (NF-e)</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('numeroproximanotafiscal', 'Próximo Número da NF-e'); !!}
                        {!!Form::text('numeroproximanotafiscal', $numeroproximanotafiscal, array('class' => 'form-control', 'placeholder' => 'DIGITE O Número'));!!}
                    </div>
                    <div class="col-xs-4">
                        <label>Nº da Série <a href="#" class="text-muted"><i alt="Número máximo 889" class="fa fa-gear"></i></a></label>
                        {!!Form::text('numeroserie', $numeroserie, array('class' => 'form-control', 'placeholder' => 'DIGITE A SÉRIE'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('notafiscaltipomovimentacao', 'Orientação da impressão'); !!}
                        <select class="form-control select2" name="idnotafiscaltipomovimentacao" style="width: 100%;">
                            @foreach ($NotaFiscalOrientacao as $orientacao)
                                <option value="{{$orientacao->id}}" {{$idnotafiscaltipomovimentacao == $orientacao->id ? 'selected': ''}}>{{$orientacao->descricao}}</option>
                            @endforeach
                        </select>
                    </div>                                        
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection
