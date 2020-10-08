@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-9">
        <div class="row">
            <div class="col-xs-1">
                {!!Form::label('codigo', 'Código'); !!}
                {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
            </div>
        <div class="col-xs-4">
            {!!Form::label('tipo', 'Efetuar'); !!}
            <select id="idfinanceirolancamentotipo" name="idfinanceirolancamentotipo" {{$id > 0 ? 'disabled' : ''}}  class="form-control select2" style="width: 100%;">
                @foreach ($financeirolancamentotipos as $lancamentotipo)
                    <option value="{{$lancamentotipo->id}}" {{$idfinanceirolancamentotipo == $lancamentotipo->id ? 'selected' : ''}}>{{$lancamentotipo->descricao}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xs-3">
            {!!Form::label('tipo', 'Lançamento'); !!}
            <select id="idlancamentotipolancamento" name="idlancamentotipolancamento" class="form-control select2" disabled="disabled" style="width: 100%;">
                @foreach ($lancamentotipolancamentos as $tipo)
                    <option value="{{$tipo->id}}" {{$idlancamentotipolancamento == $tipo->id ? 'selected' : ''}}>{{$tipo->descricao}}</option>
                @endforeach
            </select>
        </div>
        </div>
        <div id="boxLancamento" class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Lançamento</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" id="idlacamentopartial">
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $.namespace("updatefinanceirolacamento", function(){
        var publico = {};

        var tipolacamentoOnChange = function(){
            var that = $(this).val();
            var url = "/financeirolancamento/obterfinanceirolancamentopartial";
            var parametro = {id : that};
            var box = $("#boxLancamento");
            box.startLoad()
            $.get(url, parametro, function(data){
                $("#idlacamentopartial").html(data)
                box.removeLoad();
            });
        };

        publico.init = function(){
            $("#idfinanceirolancamentotipo").on("change", tipolacamentoOnChange);
            $("#idfinanceirolancamentotipo").trigger("change");
        };

        return publico;
    });

    $(function(){
        $.namespace("updatefinanceirolacamento").init();
    });
</script>
@endpush