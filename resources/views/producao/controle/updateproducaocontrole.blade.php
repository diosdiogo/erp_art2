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
                    <div class="col-xs-3">
                        {!!Form::label('at_update', 'Data execução'); !!}
                        {!!Form::date('dataexecucao', $dataexecucao, array('class' => 'form-control'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('produto_label', 'Produto'); !!}
                        <select id="idproduto" name="idproduto" class="form-control select2" style="width: 100%;">
                            @if($descricaoproduto)
                                <option value="{{$idproduto}}">{{$descricaoproduto}}</option>
                            @endif;
                        </select>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('produto_label', 'Funcionário'); !!}
                        <select id="idpessoa" name="idpessoa" class="form-control select2" style="width: 100%;">
                            @if($descricaopessoa)
                                <option value="{{$idpessoa}}">{{$descricaopessoa}}</option>
                            @endif;
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('produto_label', 'Máquina'); !!}
                        <select id="idproducaomaquina" name="idproducaomaquina" class="form-control select2" style="width: 100%;">
                            @if($descricaoproduto)
                                <option value="{{$idproducaomaquina}}">{{$descricaoproducaomaquina}}</option>
                            @endif;
                        </select>
                    </div>
                </div>                        
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('descricao', 'Quantidade'); !!}
                        {!!Form::text('estoquequantidade', $estoquequantidade, array('class' => 'form-control money'));!!}
                    </div>
                </div>                                            
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('tipo', 'Observação'); !!}<br>
                        {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $.namespace('updateproducaocontrole', function(){
        var publico = {};
        var produto = $("#idproduto");

        publico.init = function(){
            inicializarEventos();
        }

        var inicializarEventos = function(){
            updatetemplatejs.comboBoxSelect("idproduto", "/producaocontrole/obterproduto");
            updatetemplatejs.comboBoxSelect("idpessoa", "/producaocontrole/obterpessoa");
            updatetemplatejs.comboBoxSelect("idproducaomaquina", "/producaocontrole/obterproducaomaquina");
            inicializarEventoProduto();
        }

        var inicializarEventoProduto = function(){
            produto.on("change", produtoOnChange);

            if(produto.isNullOrEmpty()){
                produto.selectOpen();
                $("input[type='search']").focus();
            }else
                setarDescricaoProduto();
        }

        var setarDescricaoProduto = function(){
            $("#descricao").val($("#select2-idproduto-container").text());
        }

        var produtoOnChange = function(e){
            setarDescricaoProduto();
        }

        return publico;
    });

    $(function() {
        $.namespace('updateproducaocontrole').init();
    });

</script>
@endpush