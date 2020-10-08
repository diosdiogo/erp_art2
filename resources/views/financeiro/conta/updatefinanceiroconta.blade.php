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
                            Ativo: {!!Form::CheckBox('ativo', true, $ativo, array('class' => 'flat-red')) !!}
                        </label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('descricao', 'Descrição'); !!}
                        {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição'));!!}
                    </div>

                    <div class="col-xs-3">
                        {!!Form::label('banco', 'Banco'); !!}
                        <select id="idfinanceirobanco" name="idfinanceirobanco" class="form-control select2" style="width: 100%;">
                            @if($descricaobanco)
                              <option value="{{$idfinanceirobanco}}">{{$descricaobanco}}</option>
                            @endif;
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('descricao', 'Agência'); !!}
                        {!!Form::text('agencia', $agencia, array('class' => 'form-control', 'placeholder' => 'Digite a agência'));!!}
                    </div>      
                    <div class="col-xs-2">
                        {!!Form::label('descricao', 'Digito'); !!}
                        {!!Form::text('agenciadigito', $agenciadigito, array('class' => 'form-control'));!!}
                    </div>

                    <div class="col-xs-3">
                        {!!Form::label('descricao', 'Conta'); !!}
                        {!!Form::text('conta', $conta, array('class' => 'form-control', 'placeholder' => 'Digite a conta'));!!}
                    </div>      
                    <div class="col-xs-2">
                        {!!Form::label('descricao', 'Digito'); !!}
                        {!!Form::text('contadigito', $contadigito, array('class' => 'form-control'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
 $.namespace("updatefinanceiroconta", function(){
    var publico = {};

    publico.init = function () {
        updatetemplatejs.comboBoxSelect("idfinanceirobanco", "/financeiroconta/obterfinanceiroconta");
        $("idfinanceirobanco").select2("data", { id: '{{$idfinanceirobanco}}', text: '{{$descricaobanco}}' });
    };

    return publico;
 });

 $(function(){
    $.namespace("updatefinanceiroconta").init();
 });
</script>
@endpush