@extends('template/gridtemplate')

@section('content')
@include('venda/_gridvenda')
@include('template/gridhelper', array('botaoPersonalizado' => 
'
<a type="button" id="btnReabrir" class="btn btn-default"><i class="fa fa-reply"></i> Reabrir</a>
<a type="button" id="btnFaturar" class="btn btn-default"><i class="fa fa-cc-visa"></i> Faturar</a>
<a type="button" id="btnImprimir" class="btn btn-default"><i class="fa fa-file-text"></i> Imprimir</a>
<a type="button" id="btnNotaFiscal" class="btn btn-default"><i class="fa fa-file-text"></i> Nota Fiscal</a>'))

<style>
    .pesquisaData{
        display: block;
    }
</style>
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
            title: "Valor total",
            field: "valortotal",
            encoded: true,
            template: "#= kendo.toString(valortotal / 100, 'c2') #"
        },
        {
            title: "Situacao",
            field: "valortotal",
            encoded: true,
            template: '<span class="label #=idvendasituacao == 1 ? "label-warning" : (idvendasituacao == 2 ? "label-success" :"label-warning") #">#=situacao#</span>',
        },
        {
            title: "Pessoa",
            field: "nomepessoa",
            encoded: true,
        },
        {
            title: "Data venda",
            field: "datavenda",
            encoded: true,
            template: "#= kendo.toString(kendo.parseDate(datavenda), 'dd/MM/yyyy') #"
        },
        gridnamespace.botaoVisualizar()];
        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    nome: {
                        type: "string"
                    },
                    valortotal: {
                        type: "number"
                    },
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
</script>

<script src="{{asset('assets/routes/js/venda/gridvenda.js') }}"></script>
@endpush