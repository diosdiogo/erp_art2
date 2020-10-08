@extends('template/gridtemplate')

@section('content')
@include('template/gridhelper', array('filtroPersonalizado' => '<div class="col-xs-3" style="margin-left:-24px">
	 <label class="pesquisaData"> </label>            
		<select class="form-control select2" id="idDropDownList" data-placeholder="PESSOA (CLIENTE)" style="width: 100%;">
		</select>
</div>'))
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
        }, {
            title: "Preço",
            template: "#= kendo.toString((preco * 100) / 100, 'c2') #"
        },
         {
            title: "Pessoa",
            field: "razaosocial",
            encoded: true
        }];

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
<script> setTimeout(function(){ $.namespace("gridtemplatejs").comboBoxSelect("idDropDownList", "/produtopreco/obterpessoa");}, 350);</script>
@endpush