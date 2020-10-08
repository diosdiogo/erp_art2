@extends('template/gridtemplate')

@section('content')
@include('template/gridhelper')

@endsection
@push('scripts')
<script src="{{ asset('assets/routes/js/pessoa/gridpessoa.js') }}"></script>
<script>
        var gridnamespace = $.namespace("gridtemplatejs");
        
        var colunas = [{
            title: "Codigo",
            field: "id",
            width: 90,
            encoded: true
        }, {
            title: "Codigo personalizado",
            field: "codigopesonalizado",
            width: 190,
            encoded: true
        }, {
            title: "Nome",
            field: "razaosocial",
            encoded: true
        },{
            title: "Tipo",
            field: "descricao",
            width: 80,
            template: '<span class="label label-primary">#=pessoatipo#</span>',
            encoded: true,
        },{
            title: "Relacao",
            field: "descricao",
            width: 200,
            template: '#= gridpessoa.formatarStatus(descricao) #',
            encoded: true,
        },
            gridnamespace.botaoVisualizar()];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    nome: {
                        type: "string"
                    }
                };
                
        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
</script>
    
@endpush