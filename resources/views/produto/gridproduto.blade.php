@extends('template/gridtemplate')

@section('content')
@include('template/gridhelper', array('botaoPersonalizado' => '<a type="button" id="btnInserirEstoque" href="'. url('produtoestoque') .'/alterar/" class="btn btn-default"><i class="fa fa-cube"></i> Estoque</a>'))
@endsection
@push('scripts')
<script>
    var gridnamespace = $.namespace("gridtemplatejs");

        var colunas = [{
            title: "Codigo",
            field: "id",
            width: 90,
            encoded: true
        },
        {
            title: "Ativo",
            field: "ativo",
            width: 80,
            template: '<center><input type="checkbox" class="flat-red" #= ativo ? checked="checked" : "" # disabled="disabled" /></center>',
            encoded: true
        },
        {
            width: 90,
            title: "Cód Reduzido",
            template: "<center>#=codigoreduzido#</center>",
            encoded: true
        },
         {
            title: "Descricao",
            field: "descricao",
            encoded: true
        }, {
            title: "Preço",
            template: "#= kendo.toString((preco * 100) / 100, 'c2') #"
        }, gridnamespace.botaoVisualizar()];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    descricao: {
                        type: "string"
                    }
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
</script>
<script src="{{asset('assets/routes/js/produto/gridproduto.js') }}"></script>
@endpush
