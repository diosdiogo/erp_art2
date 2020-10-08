<link href="{{asset('assets/dist/css/mobi.cadastro.css') }}" rel="stylesheet" />
<style>
    .toolbar {
        float: right;
    }
    .pesquisaData{
        display: none;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        @include('template/gridtemplate-erros')
    </div>
</div>
<script type="text/x-kendo-template" id="template">
    @if($inserir)
        <a type="button" id="btnInserir" href="{{url($rotaAcao)}}/inserir/" class="btn btn-default">Inserir<i class=""></i></a>
    @endif
    {!! $botaoPersonalizado or ''!!}
    <div class="toolbar"><button type="button" id="btnAtualizar" class="btn btn-default"><i class="fa fa-refresh"></i></button></div>
</script>

<div class="row" style="margin-bottom: 5px">
        <div class="col-xs-12">
        <label>Empresa:</label>
        <select disabled="disabled" class="form-control" id="idempresa" data-placeholder="Selecione" style="width: 100%;">
            @foreach ($empresas as $empresa)
            <option id="{{$empresa->id}}">{{    $empresa->id .' - '. $empresa->nomefantasia}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="row" style="margin-bottom: 5px">
    <div class="col-xs-3">
        <label class="pesquisaData"> </label>            
        <select class="form-control select2" id="idFiltro" data-placeholder="Selecione" style="width: 100%;">
            @foreach ($filtros as $key => $filtro )
                <option id="{{$key}}">{{$filtro}}</option>
            @endforeach
        </select>
    </div>
        {!! $filtroPersonalizado or ''!!}
<div class="pesquisaData">    
    <div class="col-xs-2" style="margin-left:-24px">
        <label>Data inicial</label>
        <input type="date" value="{{$dataInicial == '' ? date('Y-m-d') : $dataInicial}}" class="form-control" id="dataInicial" />
    </div>  
    <div class="col-xs-2" style="margin-left:-24px">
        <label>Data final</label>        
        <input type="date" value="{{$dataFinal or date('Y-m-d')}}" class="form-control" id="dataFinal" />
    </div>        
</div>    
    <div class="col-xs-3" style="margin-left:-24px">
        <label class="pesquisaData"> </label>
        <input class="form-control" id="inputPesquisa" />
    </div>
    <div class="col-xs-1" style="margin-left:-24px">
        <label class="pesquisaData"> </label>
        <button type="button" id="btnPesquisar" class="btn btn-default"><i class="fa fa-search"></i></button>
    </div>
</div>

<div id="gridtemplate"></div>
{{csrf_field() }}

<script>
    var id = "{{$id or ''}}";

    var recarregarGridTemplate = function(){
        setTimeout(function () {
            if(id == "")
                return false;
                
            if($.isFunction($.gridTemplateValido) && $.gridTemplateValido()){
                var gridTemplate = $("#gridtemplate");
                var gridTemplateGrid = gridTemplate.getKendoGrid();
                gridTemplateGrid.dataSource.read({ 'id': '' + id });
                gridTemplateGrid.bind('dataBinding', function(){
                    setTimeout(function(){
                        if($.obterIdConcluirEdicao() > 0){
                            var grid = gridTemplate;
                            var tr = grid.find("tr");
                            if(tr.length > 1){
                                var classeSelecionada = 'k-state-selected';
                                $(tr[1]).addClass(classeSelecionada);
                            }
                        }
                    }, 250);
                });
                
            }else
                recarregarGridTemplate();
        }, 750)
    }

    recarregarGridTemplate();
</script>
