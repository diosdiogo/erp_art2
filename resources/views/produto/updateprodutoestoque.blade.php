@extends('template/updatetemplate')

@section('contentInteno')
<style>
</style>
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-6">
        {!!Form::label('descricao', 'Nome'); !!}
        {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite o nome do produto', 'disabled' => 'disabled'));!!}
    </div>
    <div class="col-xs-3">
        {!!Form::label('site', 'Código de barras'); !!}
        <div class="input-group">
            <span class="btn btn-default input-group-addon"><i class="fa fa-barcode"></i></span>
            {!!Form::text('codigobarra', $codigobarra, array('class' => 'form-control', 'placeholder' => 'Digite o código de barras: 00000000000', 'disabled' => 'disabled'));!!}
        </div>
    </div>
</div>
<div class="row">
</div>
<div class="row">
    <div class="col-xs-3">
        <label>Unidade</label>
        <select class="form-control select2" name="idunidademedida" disabled="disabled" data-placeholder="Selecione" style="width: 100%;">
            <option value="">SELECIONE</option>
            @foreach ($unidadesmedida as $unidademedida)
            <option value="{{$unidademedida->id}}" {{$idunidademedida == $unidademedida->id ? 'selected': ''}}>{{    $unidademedida->descricao}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-3">
        {!!Form::label('site', 'Quantidade caixa'); !!}
        <div class="input-group">
            <span class="btn btn-default input-group-addon"><i class="fa fa-archive"></i></span>
            {!!Form::text('estoquequantidadecaixa', $estoquequantidadecaixa, array('class' => 'form-control', 'placeholder' => 'Digite unidade caixa', 'disabled' => 'disabled'));!!}
        </div>
    </div>
</div>
<br />
<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span id="box-money" class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Margem de lucro</span>
                <span id="margemlucro" class="info-box-number">0<small>%</small></span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Estoque atual</span>
                <span class="info-box-number trescasasdecimais" id="info-estoquequantidade">{{$estoquequantidade}}</span>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Unidade</span>
                <span class="info-box-number" id="info-estoqueunidade">{{$estoqueunidade}}</span>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-9">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Valores</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('Custo', 'Custo'); !!}
                        {!!Form::text('custocompra', $custocompra, array('class' => 'form-control money', 'placeholder' => 'Digite o custo', 'disabled' => 'disabled'));!!}
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('preco', 'Preco'); !!}
                        {!!Form::text('preco', $preco, array('class' => 'form-control money', 'placeholder' => 'Digite o pre�o', 'disabled' => 'disabled'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

@if($id > 0)
<div class="row">
    <div class="col-xs-9">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Estoque</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('codigofornecedor', 'Quantidade'); !!}
                        {!!Form::text('estoquequantidade', '', array('class' => 'form-control trescasasdecimais', 'placeholder' => 'Digite a quantidade'));!!}
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('descricaofornecedor', 'Unidade'); !!}
                        {!!Form::number('estoqueunidade', '', array('class' => 'form-control', 'placeholder' => 'Digite a unidade'));!!}
                    </div>
                    <div class="col-xs-3" style="top:24px">
                        <button id="btnInserirEstoque" class="btn btn-primary">Inserir</button>
                        <button id="btnRemoverEstoque" class="btn btn-danger">Remover</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
@push('scripts')
    <script src="{{asset('assets/routes/js/produto/updateproduto.js') }}"></script>
    <script>
        var inserirOuRemoverEstoque = function(inserir){
            var estoqueunidade = $("input[name='estoqueunidade']");
            var estoquequantidade = $("input[name='estoquequantidade']");

            var infoestoquequantidade = $("#info-estoquequantidade");
            var infoestoqueunidade = $("#info-estoqueunidade");

            if(inserir){
                var quantidade = $.tratarValor(infoestoquequantidade.html()) + $.tratarValor(estoquequantidade.val());
                var unidade = Number(infoestoqueunidade.html()) + parseFloat(estoqueunidade.val());

                if(quantidade > 0)
                    infoestoquequantidade.html($.toMoneySimples(quantidade, 3));
                if(unidade > 0)
                    infoestoqueunidade.html(unidade);
            }else{
                var quantidade =  $.tratarValor(infoestoquequantidade.html()) - parseFloat(estoquequantidade.val());
                var unidade = parseFloat(infoestoqueunidade.html()) - parseFloat(estoqueunidade.val());

                if(parseFloat(estoquequantidade.val()) > 0 && quantidade > 0){
                    infoestoquequantidade.html(isNaN(quantidade) ? "0" : quantidade);
                }

                if(parseFloat(estoqueunidade.val()) > 0){
                    infoestoqueunidade.html(isNaN(unidade) ? "0" : unidade);
                }
            }
                        
            estoqueunidade.val("");
            estoquequantidade.val("");
        }
        
        $("#btnInserirEstoque").on("click", function(e){
            e.preventDefault();
            inserirOuRemoverEstoque(true);
        });

        $("#btnRemoverEstoque").on("click", function(e){
            e.preventDefault();
            inserirOuRemoverEstoque(false);
        });

        $("#btnSalvar").on("click", function(){
            var infoestoquequantidade = $.tratarValor($("#info-estoquequantidade").html());
            var infoestoqueunidade = parseFloat($("#info-estoqueunidade").html());

            var estoqueunidade = $("input[name='estoqueunidade']");
            estoqueunidade.val("" + infoestoqueunidade);

            var estoquequantidade = $("input[name='estoquequantidade']");
            estoquequantidade.val("" + infoestoquequantidade);
        });
    </script>
@endpush