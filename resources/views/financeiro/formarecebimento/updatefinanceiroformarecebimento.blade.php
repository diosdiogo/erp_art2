@extends('template/updatetemplate')
@section('contentInteno')
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
        <div class="col-xs-7">
            {!!Form::label('descricao', 'Descrição'); !!}
            {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição'));!!}
        </div>
        <div class="col-xs-4">
            {!!Form::label('produto_label', 'Espécie (Padrão)'); !!}
            <select class="form-control select2" id="idfinanceirotipo" name="idfinanceirotipo" style="width: 100%;">
                <option value="">[SELECIONE]</option>
                @foreach ($tipos as $tipo)
                    <option value="{{$tipo->id}}" {{$idfinanceirotipo == $tipo->id ? 'selected' : ''}}>{{$tipo->descricao}}</option>
                @endforeach
            </select>
        </div>
    </div>
<div class="row">
    <div class="col-xs-11">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">CONDIÇÕES DE PAGAMENTO</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#itemModal" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                        </div>
                        <div class="box-body">
                          <table id="griditem" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>PARCELAS</th>
                                    <th>RECORRÊNCIA</th>
                                    <th>1ª PARCELA</th>
                                    <th>NAS COMPRAS?</th>
                                    <th>NAS VENDAS?</th>
                                    <th width="90px"></th>
                                </tr>
                            </thead>
                            <tr>
                                <tbody>
                                  
                                </tbody>
                            </tr>
                        </table>
                        </div>
                        <!-- /.box-body -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Salvar condição de pagamento</h4>
      </div>
     <div id="idPopUpErro" style="display:none; margin-left: 5px; margin-right: 5px" class="callout callout-danger">
        <h4>Atenção!</h4>
        <p></p>
    </div>
    <form method="POST" id="form-item">
      <div class="modal-body">
           @include('template/_aguarde')    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button type="submit" id="salvarItem" class="btn btn-primary">Salvar</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
    <script>

    $.namespace('updatefinanceiroformarecebimento', function(){
        var publico = {};
        var gridElemento = $('#griditem');
        var alterar = false;
        var modal = $('#itemModal');

        var salvarItemOnClick = function(){
            $("#form-item").trigger("submit");
        }

        publico.init = function(){
            inicializarEventos();
        }

        var inicializarEventos = function(){
            //$("#salvarItem").on("click", salvarItemOnClick);
            $("#form-item").submit(salvarOnClick);
            $('#griditem tbody').on("click", "a.btn-warning", alterarItemOnClick);
            $('#griditem tbody').on( 'click', 'a.btn-danger', deletarItemOnClick);
            modal.on('hidden.bs.modal', modalHidden);
            modal.on('shown.bs.modal', modelShow);
        }

        var salvarOnClick = function (e){
            if($("#form-item input[name='descricao']").val() != "" && $("#form-item input[name='descricao']").val() != undefined){
                var grid = $('#griditem').DataTable();
                var viewModel = $(this).serialize();
                var urlAlterarInserir = (alterar ? "alterar" : "inserir") + "financeiroformarecebimentoitem";
                var url = "/financeiroformarecebimento/" + urlAlterarInserir;

                $.post(url, viewModel, function(data){
                    grid.ajax.reload();
                    modal.modal('hide');
                }).fail(function(data){
                /* $("#idPopUpErro").show();
                    var json = JSON.parse(data.responseText);
                $("#idPopUpErro").html(data.responseText);
                    debugger;*/
                });
            }

            e.preventDefault();
        }

        var alterarItemOnClick = function(){
            var grid = gridElemento.DataTable();
            var row = grid.row($(this).parents('tr'));
            var data = row.data();
            alterar = true;

            if(data != null){
                var url = "/financeiroformarecebimento/alterarfinanceiroformarecebimentoitem";
                var parametro = {'id' : data.id};
                $.get(url, parametro, function(data){
                    $("#form-item").find(".modal-body").html(data);
                    modal.modal('show');
                });
            }else
                 sweetAlert("Alerta!", "Selecione um registro", "error");
        }

        var deletarItemOnClick = function(){
            var grid = gridElemento.DataTable();
            var row = grid.row($(this).parents('tr'));
            var data = row.data();

            if(data != null){
                var url = "/financeiroformarecebimento/deletarfinanceiroformarecebimentoitem";
                var parametro = {'id' : data.id};
                $.post(url, parametro, function(){
                    row.remove().draw();
                });
            }else
                 sweetAlert("Alerta!", "Selecione um registro", "error");
        }

        var modelShow = function(){
            if(!alterar){
                var box = $("#boxLancamento");
                box.startLoad()
                box.removeLoad();
                var url = "/financeiroformarecebimento/inserirfinanceiroformarecebimentoitem";
                $.get(url, function(data){
                    $("#form-item").find(".modal-body").html(data);
                });
            }
        }

        var modalHidden = function(){
            alterar = false;
            $(this).find("input:text, textarea, select").val('').end();
            $(this).find(".flat-red").iCheck('check'); 
            $(this).find(".callout").html("");
            $(this).find(".callout").hide();
        }

        gridElemento.DataTable( {
            "bFilter": false,
            "bPaginate": false,
            "info": false,
            "ajax": {
                "url": "/financeiroformarecebimento/obteritens",
                "dataSrc": ""
            },
            "columnDefs": [ {
                    "targets": -1,
                    "data": null,
                    "defaultContent": ""
            } ],
            "columns": [
                { "data": "id" },
                { "data": "descricao" },
                { "data": "numeroparcelas" },
                { "data": "recorrencia" },
                { "data": "diaprimeiraparcela" },
                {
                    data:   "utilizacompra",
                    render: function ( data, type, full, meta ) {
                        if ( type === 'display' ){
                            var mensagem = full.utilizacompra == 1 ? 'SIM' : 'NÃO';
                            return mensagem;
                        }

                        return data;
                    },
                    className: "dt-body-center"
                },
                {
                    data:   "utilizavenda",
                    render: function ( data, type, full, meta ) {
                        if ( type === 'display' ){
                            var mensagem = full.utilizavenda == 1 ? 'SIM' : 'NÃO';
                            return mensagem;
                        }

                        return data;
                    },
                    className: "dt-body-center"
                },
                {
                        sortable: false,
                        "render": function ( data, type, full, meta ) {
                        var buttonID = "withdraw_"+full.id;
                        return '<a class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>  <a class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
                    }
                },
            ]
        } );

        return publico;
    });

    $(function() {
        $.namespace('updatefinanceiroformarecebimento').init();
    });
    </script>
@endpush
