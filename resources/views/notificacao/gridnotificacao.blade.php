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
            title: "Texto",
            field: "texto",
            encoded: true
        },
            gridnamespace.botaoVisualizar(true)
        ];

        var colunasConfiguracao = {
            id: {
                type: "number"
            },
            nome: {
                type: "string"
            },
        };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao, false);

        function showDetails(e) {
            e.preventDefault();
        }
</script>
<script src="{{asset('assets/routes/js/pessoa/gridpessoa.js') }}"></script>
@endpush