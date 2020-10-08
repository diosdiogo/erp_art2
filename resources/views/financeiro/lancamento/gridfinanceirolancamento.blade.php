@extends('template/gridtemplate')

@section('content')
@include('financeiro/lancamento/_gridfinanceirolancamento')

@include('template/gridhelper',  array('botaoPersonalizado' => '<a type="button" id="btnDocumento" class="btn btn-default"><i class="fa fa-file-text"></i> Documento</a>'))
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
            title: "Observacao",
            field: "observacao",
            encoded: true
        },{
            title: "Valor",
            field: "valor",
            encoded: true,
            template: "#= kendo.toString(valor / 100, 'c2') #"
        },{
            title: "Tipo",
            field: "descricao",
            template: '<span class="label #=idfinanceirolancamentotipo == 1 ? "label-danger" : (idfinanceirolancamentotipo == 2 ? "label-success" :"label-warning") #">#=descricao#</span>',
            encoded: true,
        },{
            title: "Lacamento",
            field: "descricao",
            template: '<span class="label label-primary">#=lacamentotipo#</span>',
            encoded: true,
        },
            gridnamespace.botaoVisualizar()];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    observacao: {
                        type: "string"
                    },
                    valor: {
                        type: "number"
                    },
                    descricao: {
                        type: "string"
                    },
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);

        $.namespace('gridfinanceirolancamento', function(){
            var publico = {};

            publico.init = function(){
                $("#btnDocumento").on("click", documentoOnClick);
            }

            var documentoOnClick = function(e){
                 $.executarChamadaAjaxGrid(e, function(){
                    var grid = $("#gridtemplate");
                    var numerodocumento = grid.obterLinhaGridItem().numerodocumento;
                    var url = "";

                    switch(grid.obterLinhaGridItem().idfinanceirolancamentotipo){
                        case 5:
                            url = "/financeirocontareceber/visualizar/" + numerodocumento;
                        break;
                        case 4:
                            url = "/financeirocontapagar/visualizar/" + numerodocumento;
                        break;                        
                    }
                    
                    if(url != "")
                        window.open(url, "_blank");
                }); 
            }

            return publico;
        });

        $(function(){
            $.namespace('gridfinanceirolancamento').init();
        });
    </script>
@endpush
