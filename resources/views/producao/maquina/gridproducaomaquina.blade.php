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
            width: 90
        }, {
            title: "Descricao",
            field: "descricao"
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
@endpush
