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
                    <div class="col-xs-3">
                        {!!Form::label('codigo', 'Data lida'); !!}
                        {!!Form::datetime('updated_at', $created_at, array('class' => 'form-control datepicker', 'disabled' => 'disabled'));!!}
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('codigo', 'Data lida'); !!}
                        {!!Form::datetime('updated_at', $updated_at, array('class' => 'form-control datepicker', 'disabled' => 'disabled'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        {!!Form::label('descricao', 'Titulo'); !!}
                        {!!Form::text('titulo', $titulo, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-7">
                        {!!Form::label('descricao', 'Mensagem'); !!}
                        {!!Form::textArea('texto', $texto, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function(){
        $("#btnSalvar").attr('disabled', 'disabled');
    })
</script>
@endpush