<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" name="id" value={{$id}}>
<input type="hidden" id="descricao" name="descricao" value={{$descricao}}>
<input type="hidden" id="unidademedidacomercial" name="unidademedidacomercial" value={{$unidademedidacomercial}}>
<input type="hidden" id="valordesconto" name="valordesconto" value={{$valordesconto}}>
{{-- @if($isEmpresaFrigorifico)
    <div class="row" id="alertaPreco"  style="display: none">
        <div class="col-xs-12">
            <div class="callout callout-warning">
                <h4>Informação!</h4>

                <p>Este produto foi vendido anteriormente por <b style="font-size: 20px" id="ultimoPrecoPedido">R$10,50</b>.</p>
            </div>
        </div>
    </div>
@endif --}}
<div class="row">
    <div class="col-xs-12">
        {!!Form::label('produto_label', 'Produto'); !!}
        <select id="idproduto" name="idproduto" class="form-control select2" readonly='readonly' style="width: 100%;">
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
        {!!Form::label('descricao', 'Valor unitario'); !!}
        {!!Form::text('valorunitario', $valorunitario, array('class' => 'form-control money', 'required' => 'required', ($origemvenda > 0 ? 'readonly' : '')  => 'readonly' ));!!}
    </div>      
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Quantidade'); !!}
        {!!Form::text('quantidade', $quantidade, array('class' => 'form-control trescasasdecimais', ($origemvenda > 0 ? 'readonly' : '')  => 'readonly' ));!!}
    </div>
    <div class="col-xs-4">
        {!!Form::label('descricao', 'Valor total'); !!}
        {!!Form::text('valortotal', $valortotal, array('class' => 'form-control money', ($origemvenda > 0 ? 'readonly' : '')  => 'readonly' ));!!}
    </div>    
</div>
<div class="row">
    <div class="col-xs-12">
        {!!Form::label('cfop', 'CFOP Dentro do estado'); !!}
        <select id="idcfop" data-placeholder="SELECIONE" name="idcfop" class="form-control select2" style="width: 100%;">
            @if($descricaocfop)
                <option value="{{$idcfop}}">{{$descricaocfop}}</option>
            @endif;
        </select>
    </div>
</div>
<div class="row">
<div class="col-xs-12">
    {!!Form::label('cst', 'CST ou CSOSN'); !!}
    <select id="idcsticms" name="idcsticms" data-placeholder="SELECIONE" class="form-control select2" style="width: 100%;">
        @if($descricaocsticms)
            <option value="{{$idcsticms}}">{{$descricaocsticms}}</option>
        @endif;
    </select>
</div>
<script>
    $("#idproduto").select2().attr('readonly','readonly');
     updatetemplatejs.comboBoxSelect("idcfop", "/fiscalnaturezaoperacao/obtercfop");
     updatetemplatejs.comboBoxSelect("idcsticms", "/notafiscal/obtercsticms");
</script>
<script src="{{asset('assets/routes/js/fiscal/notafiscal/updatenotafiscalitem.js') }}"></script>
<script>$("idproduto").select2("data", { id: '{{$idproduto}}', text: '{{$descricao}}' });</script>