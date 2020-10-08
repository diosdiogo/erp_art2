@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-10">
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
                            Ativo: {!!Form::CheckBox('ativo', $ativo, $ativo, array('class' => 'flat-red')) !!}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('descricao', 'Descrição'); !!}
                    {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection