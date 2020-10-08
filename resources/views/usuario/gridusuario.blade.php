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
            title: "Nome",
            field: "name",
            encoded: true
        },  gridnamespace.botaoAcao(gridnamespace.acaoEnum.SEMDELETE)];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    name: {
                        type: "string"
                    },
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
    </script>
@endpush
