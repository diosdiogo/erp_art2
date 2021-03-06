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
            title: "Descricao",
            field: "descricao",
            encoded: true
        }, {
            title: "Placa",
            field: "placa",
            encoded: true
        },
            gridnamespace.botaoVisualizar()];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    descricao: {
                        type: "string"
                    },
                    placa: {
                        type: "string"
                    }
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
    </script>
@endpush
