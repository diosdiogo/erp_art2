<div class="row">
    <div class="col-xs-1">
        {!!Form::label('codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
    <div class="col-xs-6" style="margin-top: 30px">
        <label>
            Ativo: {!!Form::CheckBox('ativo', true, $ativo, array('class' => 'flat-red')) !!}
        </label>   
        <label>
            CONTABILIZA ESTOQUE? {!!Form::CheckBox('contabilizaestoque', true, $contabilizaestoque, array('class' => 'flat-red')) !!}
        </label>
    </div>
   
</div>
<div class="row">
    <div class="col-xs-6">
        {!!Form::label('descricao', 'Nome'); !!}
        {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite o nome do produto', 'autofocus' => 'autofocus', ($id == 1 ? 'readonly' : '')  => 'readonly' ));!!}
    </div>
    <div class="col-xs-3">
        {!!Form::label('site', 'Código de barras'); !!}
        <div class="input-group">
            <span class="btn btn-default input-group-addon"><i class="fa fa-barcode"></i></span>
            {!!Form::text('codigobarra', $codigobarra, array('class' => 'form-control', 'placeholder' => 'Digite o código de barras: 00000000000'));!!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <label>Unidade</label>
        <select class="form-control select2" name="idunidademedida" data-placeholder="SELECIONE" style="width: 100%;">
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
            {!!Form::text('estoquequantidadecaixa', $estoquequantidadecaixa, array('class' => 'form-control', 'placeholder' => 'Digite quantidade caixa'));!!}
        </div>
    </div>
    <div class="col-xs-3">
        <label>Categoria</label>
        <select class="form-control select2" name="idprodutocategoria" data-placeholder="SELECIONE" style="width: 100%;">
            <option value="">SELECIONE</option>
            @foreach ($categorias as $categoria)
            <option value="{{$categoria->id}}" {{$idprodutocategoria == $categoria->id ? 'selected': ''}}>{{$categoria->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-3">
        <label>Marca</label>
        <select class="form-control select2" name="idprodutomarca" data-placeholder="SELECIONE" style="width: 100%;">
            <option value="">SELECIONE</option>
            @foreach ($marcas as $marca)
            <option value="{{$marca->id}}" {{$idprodutomarca == $marca->id ? 'selected': ''}}>{{    $marca->descricao}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-3">
        {!!Form::label('site', 'Modelo'); !!}
        <div class="input-group">
            <span class="btn btn-default input-group-addon"><i class="fa fa-tag"></i></span>
            {!!Form::text('modelo', $modelo, array('class' => 'form-control', 'placeholder' => 'Digite o modelo'));!!}
        </div>
    </div>
    <div class="col-xs-3">
        {!!Form::label('site', 'Código reduzido'); !!}
        <div class="input-group">
            <span class="btn btn-default input-group-addon"><i class="fa fa-tag"></i></span>
            {!!Form::text('codigoreduzido', $codigoreduzido, array('class' => 'form-control', 'placeholder' => 'Digite o código reduzido'));!!}
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
                <span class="info-box-number">{{$estoquequantidade}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-archive"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Unidade</span>
                <span class="info-box-number">{{$estoqueunidade}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<div class="row">
    <div class="col-xs-10">
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
                        {!!Form::text('custocompra', $custocompra, array('class' => 'form-control money', 'placeholder' => 'Digite o custo'));!!}
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('preco', 'Preço'); !!}
                        {!!Form::text('preco', $preco, array('class' => 'form-control money', 'placeholder' => 'Digite o preço'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 

<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Fornecedor</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        {!!Form::label('produto_label', 'Fornecedor'); !!}
                        <select id="idpessoafornecedor" name="idpessoafornecedor" data-placeholder="SELECIONE" class="form-control select2" style="width: 100%;">
                            @if($descricaopessoafornecedor)
                                <option value="{{$idpessoafornecedor}}">{{$descricaopessoafornecedor}}</option>
                            @endif;
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('codigofornecedor', 'Código'); !!}
                        {!!Form::text('codigofornecedor', $codigofornecedor, array('class' => 'form-control', 'placeholder' => 'Digite o código do produto fornecedor'));!!}
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('descricaofornecedor', 'Descrição'); !!}
                        {!!Form::text('descricaofornecedor', $descricaofornecedor, array('class' => 'form-control', 'placeholder' => 'Digite a descrição do produto fornecedor'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>