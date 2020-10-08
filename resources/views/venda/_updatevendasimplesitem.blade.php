<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value={{$id}}>
<input type="hidden" id="descricao" name="descricao" value={{$descricao}}>
<input type="hidden" id="quantidadequadradotexto" name="quantidadequadradotexto" value={{$quantidadequadradotexto}}>
@if($isEmpresaFrigorifico)
    <div class="row" id="alertaPreco"  style="display: none">
        <div class="col-xs-12">
            <div class="callout callout-warning">
                <h4>Informação!</h4>

                <p>Este produto foi vendido anteriormente por <b style="font-size: 20px" id="ultimoPrecoPedido">R$00,00</b>.</p>
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-xs-12">
        {!!Form::label('produto_label', 'Produto'); !!}
        <select id="idproduto" name="idproduto" class="form-control select2" style="width: 100%;">
            @if($descricao)
                <option value="{{$idproduto}}">{{$descricao}}</option>
            @endif;
        </select>
    </div>
</div>
<div class="row" id="divProduto" style="{{$idproduto == 1 ? '' : 'display:none'}}">
    <div class="col-xs-12">
        {!!Form::label('nome', 'Produto (Nome)'); !!}
        {!!Form::text('produtonomegenerico', $produtonomegenerico, array('class' => 'form-control'));!!}
    </div>
</div>
<div class="row">
        <div class="col-xs-4">
            {!!Form::label('acrescimomoeda', 'Acrescimo'); !!}
            {!!Form::text('acrescimomoeda', $acrescimomoeda, array('class' => 'form-control money', 'required' => 'required'));!!}
        </div>
        
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Desconto (R$)'); !!}
        {!!Form::text('descontomoeda', $descontomoeda, array('class' => 'form-control money', 'required' => 'required'));!!}
    </div>
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Desconto (%)'); !!}
        {!!Form::text('descontoporcentagem', $descontoporcentagem, array('class' => 'form-control porcentagem', 'required' => 'required'));!!}
    </div>  
</div>
<div class="row">
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Valor unitario'); !!}
        {!!Form::text('valorunitario', $valorunitario, array('class' => 'form-control money', 'required' => 'required'));!!}
    </div>      
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Quantidade'); !!}
        {!!Form::text('quantidade', $quantidade, array('class' => $isEmpresaFrigorifico ? 'form-control trescasasdecimais' : 'form-control money'));!!}
    </div>
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Valor total'); !!}
        {!!Form::text('valortotal', $valortotal, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
    </div>    
</div>
@if($isEmpresaFrigorifico)
    <div class="row">
            <div class="col-xs-4">
            <label style="margin-top: 26px; margin-left: 32px">
                QUADRADO? {!!Form::CheckBox('quantidadequadrado', $quantidadequadrado, $quantidadequadrado, array('class' => 'flat-red')) !!}
            </label>
            </div>
            
            <div class="col-xs-4">
                {!!Form::label('quantidadepeca', 'Quantidade quadrados'); !!}
                <div class="input-group input-group">
                    {!!Form::number('quantidadepeca', $quantidadepeca == null ? 0 : $quantidadepeca, array('class' => 'form-control', 'required' => 'required'));!!}
                    <span class="input-group-btn">
                        <button type="button" id="btnAtualizarQuadrado" class="btn btn-primary"> <i class="fa fa-refresh"></i></button>
                    </span>
                </div>
            </div>        
    </div>
    <div class="row">
        <div id="divQuadrados">
            @if($quantidadequadrado)
                @include('venda._updatevendaitemquantidade', array(
                    'quantidadeQuadrado' => $quantidadepeca,
                    'quantidadequadradotexto' => $quantidadequadradotexto
                ))
            @endif
        </div>
    </div>
@elseif($isEmpresaMateriasConstrucao)
<div class="row">
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Altura'); !!}
        {!!Form::text('altura', $altura, array('class' => 'form-control money'));!!}
    </div>
        <div class="col-xs-4">
        {!!Form::label('descricao', 'Largura'); !!}
        {!!Form::text('largura', $largura, array('class' => 'form-control money'));!!}
    </div>
</div>
@endif

<script src="{{asset('assets/routes/js/venda/updatevendasimplesitem.js') }}"></script>
<script>$("idproduto").select2("data", { id: '{{$idproduto}}', text: '{{$descricao}}' });</script>

