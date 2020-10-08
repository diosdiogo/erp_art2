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
        },
         {
            title: "Descricao",
            field: "descricao",
            encoded: true
        },  gridnamespace.botaoVisualizar(true, true)];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    codigobanco: {
                        type: "string"
                    },
                    descricao: {
                        type: "string"
                    },
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
    </script>
@endpush
