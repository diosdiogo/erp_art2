@extends('template/gridtemplate')

@section('content')
@include('template/gridhelper')
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
            title: "Permite venda com estoque negativo",
            field: "permitevendacomestoquenegativo",
            template: '<input type="checkbox" class="flat-red" #= permitevendacomestoquenegativo ? checked="checked" : "" # disabled="disabled" />',
            encoded: true
        }, gridnamespace.botaoAcao(gridnamespace.acaoEnum.SEMDELETE)];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    permitevendacomestoquenegativo: {
                        type: "boolean"
                    }
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
    </script>
@endpush
