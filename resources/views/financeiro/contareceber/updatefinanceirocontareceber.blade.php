@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-1">
                {!!Form::label('codigo', 'Código'); !!}
                {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
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
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-10">
                        <img src="{{url('assets/image/financeiro/barcode_long.png')}}" alt="codigodebarras" style="margin-bottom: 5px;width:1325px; height: 60px" />
                        {!!Form::text('codigobarras', $codigobarras, array('class' => 'form-control', 'placeholder' => 'Digite o código de barras'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        {!!Form::label('codigo', 'Classificacao'); !!}
                        <select id="idfinanceirocontagerencial" name="idfinanceirocontagerencial" class="form-control select2" style="width: 100%;">
                            @foreach ($financeirocontagerenciais as $tipo)
                                <option value="{{$tipo->id}}" {{$idfinanceirocontagerencial == $tipo->id ? 'selected' : ''}}>{{$tipo->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-5">
                        {!!Form::label('codigo', 'Descrição/Beneficiário'); !!}
                        {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-5">
                        {!!Form::label('tipo', 'Observação'); !!}
                        {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}<br>
                    </div>
                        <div class="col-xs-5">
                            {!!Form::label('codigo', 'Vencimento'); !!}
                            {!!Form::date('datavencimento', $datavencimento, array('class' => 'form-control'));!!}
                            {!!Form::label('codigo', 'Valor total'); !!}
                            {!!Form::text('valortotal', $valortotal, array('class' => 'form-control money', 'placeholder' => 'R$'));!!}
                            {!!Form::label('codigo', 'Situação'); !!}
                            {!!Form::text('descricaoUtil', $descricaoSituacao, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
                        </div>
                    <div class="row">
                        <div class="col-xs-10">
                                        <div class="col-md-12">
                                          <div class="box box-primary">
                                            <div class="box-header with-border">
                                                <h4>HISTÓRICO DE RECEBIMENTOS REALIZADOS</h4>
                                            </div>
                                            <div class="box-body">
                                              <table id="griditemparcela" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>DATA</th>
                                                        <th>RECEBIDO</th>
                                                        <th>DESCONTO</th>
                                                        <th>JUROS</th>
                                                        <th>FORMA</th>
                                                        <th>CONTA</th>
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <tbody>
                                  
                                                    </tbody>
                                                </tr>
                                    </table>
                                    </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-10">
                        <div class="info-box bg-green">
                            @if($idsituacao != 2)
                                <span class="info-box-icon"><i class="fa fa-money"></i></span>
                            @else
                                <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>
                            @endif
                            <div class="info-box-content">
                            @if($idsituacao != 2)
                                  <span class="info-box-text"><b>SALDO A RECEBER</b></span>
                                <span id="valorpagar" class="info-box-number">R$ 00,00</span>
                            @else
                                  <span class="info-box-text"><b>SALDO RECEBIDO</b></span><br>
                            @endif
                              <div class="progress">
                                <div class="progress-bar" style="width: 100%"></div>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script>
    $.namespace("updatefinanceirocontareceber", function(){
        var publico = {};
        var gridElementoParcela = $("#griditemparcela");
        var valorTotal = "{{$valortotal}}";
        var valorOnChange = function(){
            var that = $(this);
            var valor = that.val();
            debugger;
            $("#valorpagar").text("R$ " + valor);
        }

        publico.init = function(){
            $("#valorpagar").text("R$ " + Number(valorTotal).format());
            $("input[name='valortotal']").on("change", valorOnChange);
        }

        gridElementoParcela.DataTable( {
                "bFilter": false,
                "paging": false,
                "info": false,
                "pagingType": "full_numbers",
                "language": {
                        "sEmptyTable": "Nenhum registro encontrado",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                        "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                        "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                        "sInfoPostFix": "",
                        "sInfoThousands": ".",
                        "sLengthMenu": "_MENU_ resultados por página",
                        "sLoadingRecords": "Carregando...",
                        "sProcessing": "Processando...",
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sSearch": "Pesquisar",
                        "oPaginate": {
                            "sNext": "Próximo",
                            "sPrevious": "Anterior",
                            "sFirst": "Primeiro",
                            "sLast": "Último"
                        },
                        "oAria": {
                            "sSortAscending": ": Ordenar colunas de forma ascendente",
                            "sSortDescending": ": Ordenar colunas de forma descendente"
                        }
            },
                "ajax": {
                    "url": "/financeirocontareceber/obtercontareceberitens",
                    "dataSrc": ""
                },
                "columnDefs": [ {
                        "targets": -1,
                        "data": null,
                        "defaultContent": ""
                } ],
                "columns": [
                    {
                        data: "datapago",
                        sortable: false,
                        render: function ( data, type, full, meta ) {
                            return  '<span class="date">'+ $.dateFormate(data) +'</span>';
                        }
                    },
                    {
                        data: "valortotal",
                        sortable: false,
                        render: function ( data, type, full, meta ) {
                            return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                        }
                    },
                    {
                        data: "descontomoeda",
                        sortable: false,
                        render: function ( data, type, full, meta ) {
                            return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                        }
                    },
                    {
                        data: "jurosmoeda",
                        sortable: false,
                        render: function ( data, type, full, meta ) {
                            return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                        }
                    },                    
                    { "data": "descricaofinanceiroconta" },
                    { "data": "descricaofinanceiroformarecebimento" },
                ]
            } );

        return publico;
    });

    $(function(){
        $.namespace("updatefinanceirocontareceber").init();
    });
</script>
@endpush