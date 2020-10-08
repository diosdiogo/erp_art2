@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Dados Basicos</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-2">
                        {!!Form::label('codigo', 'Código'); !!}
                        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
                        </div>
                        <div class="col-xs-2" style="margin-top: 30px">
                            <label>
                                Ativo: {!!Form::CheckBox('ativo', $ativo, true, array('class' => 'flat-red')) !!}
                            </label>
                        </div>
                        <div class="col-xs-2" style="margin-left:-125px; margin-top: 30px">
                            <label>
                                Supervisor: {!!Form::CheckBox('supervisor', $supervisor, $supervisor, array('class' => 'flat-red')) !!}
                            </label>
                        </div>
                </div>
            <div class="row">
                <div class="col-xs-12">
                    {!!Form::label('descricao', 'Nome'); !!}
                    {!!Form::text('name', $name, array('class' => 'form-control', 'placeholder' => 'Digite o nome'));!!}
                </div>
                <div class="col-xs-12">
                    {!!Form::label('descricao', 'E-mail'); !!}
                    <input type="text" value="{{$email}}" name="email" class="form-control" placeholder="Digite o e-mail" {{$id > 0 ? 'disabled="disabled"' : ''  }} />
                </div>                
                <div class="col-xs-12">
                    {!!Form::label('descricao', 'Senha'); !!}
                    <input type="password" value="{{$password}}" name="password" class="form-control" placeholder="Digite a senha" />
                </div>                           
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
@endpush
