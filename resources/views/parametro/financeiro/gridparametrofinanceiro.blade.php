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
            title: "Verifica limite de credito",
            field: "naoverificarchecagemlimitecredito",
            template: '<input type="checkbox" class="flat-red" #= naoverificarchecagemlimitecredito ? checked="checked" : "" # disabled="disabled" />',
            encoded: true
        }, gridnamespace.botaoAcao(gridnamespace.acaoEnum.SEMDELETE)];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    naoverificarchecagemlimitecredito: {
                        type: "boolean"
                    }
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
    </script>
@endpush
