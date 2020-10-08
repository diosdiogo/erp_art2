@extends('template/gridtemplate')

@section('content')

@include('template/gridhelper',  array('botaoPersonalizado' => '<a type="button" id="btnReceber" class="btn btn-default"><i class="fa fa-credit-card"></i> Receber</a>'))
@endsection
@push('scripts')
    <script>
        var gridnamespace = $.namespace("gridtemplatejs");

        var colunas = [{
            title: "Codigo",
            field: "id",
            width: 90,
            encoded: true
        }, {
            title: "Descricao",
            field: "descricao",
            encoded: true
        },
        {
            title: "Valor total",
            field: "valortotal",
            encoded: true,
            template: "#= kendo.toString((valortotal / 100) * 100, 'c2') #"
        },
        {
            title: "Situação",
            field: "situacao",
            template: '<span class="label #= idsituacao == 1 ? "label-warning" : (idsituacao == 2 ?  "label-success" : "label label-danger") #">#=situacao#</span>',
            encoded: true,
        },
            gridnamespace.botaoVisualizar()];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    descricao: {
                        type: "string"
                    },
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);

        $.namespace('gridfinanceirocontareceber', function(){
            var publico = {};

            publico.init = function(){
                $("#btnReceber").on('click', receberOnClick);
            }

            var receberOnClick = function(e){
                $.executarChamadaAjaxGrid(e, function(){
                    var grid = $("#gridtemplate");
                    
                    if(grid.obterLinhaGridItem().idsituacao != 2){
                        var url = "/financeirolancamento/receber/" + "?id=" + grid.obterLinhaGridItemId();
                        window.open(url, "_blank");
                    }
                }); 
            }

            return publico;
        });
        
        $(function(){
            $.namespace('gridfinanceirocontareceber').init();
        })
    </script>
@endpush
