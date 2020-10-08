@extends('template/updatetemplate')
<link href="{{asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" />
@section('contentInteno')
<style>
</style>
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>

    <div>
        <button type="button" id="btnAtalhos" class="btn btn-primary" style="margin-top: 25px">
             <i class="fa fa-question"> </i>
        </button>
    </div>
    <input type="text" id="orcamento" name="orcamento" value="0" hidden>
    <input type="text" id="orcamento" name="idpessoavendedor" value="1" hidden>
    <input type="text" id="isEmpresaFrigorifico" name="isEmpresaFrigorifico" value="{{$isEmpresaFrigorifico}}" hidden>
    <input type="text" name="faturar" value="0" hidden>
</div>
<div class="row">
    <div class="col-xs-3">
        {!!Form::label('codigo', 'Data venda'); !!}
        {!!Form::date('datavenda', $datavenda, array('class' => 'form-control'));!!}
    </div>
    <div class="col-xs-3">
        {!!Form::label('codigo', 'Data entrega'); !!}
        {!!Form::date('dataentrega', $dataentrega, array('class' => 'form-control'));!!}
    </div>
    <div class="col-xs-4">
        {!!Form::label('ufs', 'Transportadora'); !!}
        <select class="form-control select2" name="idtransportadora" style="width: 100%;">
            <option value="">[SELECIONE]</option>
            @foreach ($transportadoras as $transportadora)
            <option value="{{$transportadora->id}}" {{$idtransportadora == $transportadora->id ? 'selected' : ''}}>{{$transportadora->id . ' - ' .$transportadora->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
    <div class="col-xs-8">
        {!!Form::label('ufs', 'Pessoa (F4)'); !!}
        <div class="input-group input-group">
            <select class="form-control select2" id="idpessoa" name="idpessoa" style="width: 100%;">
                <option value="">[SELECIONE]</option>
                @foreach ($clientes as $cliente)
                    <option diasemana="teste" value="{{$cliente->id}}" {{$idpessoa == $cliente->id ? 'selected' : ''}}>{{($cliente->codigopesonalizado ? $cliente->codigopesonalizado : $cliente->id) .' - ' . $cliente->nomefantasia}}</option>
                @endforeach
            </select>
            <span class="input-group-btn">
                <button type="button" id="btnInserirCliente" class="btn btn-primary"> <i class="fa fa-plus"></i></button>
            </span>
    </div>
</div>

<div class="col-xs-2" style="margin-top: 25px">
        <button type="button" id="btnInserirObservacaoCliente" class="btn btn-primary">INSERIR NA OBSERVAÇÃO</button>
</div>
</div>
<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">ITENS</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                            <button class="btn btn-primary" id="inserirItemVenda" data-toggle="modal" data-target="#itemVendaModal" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>  (F1)
                        </div>
                        <div class="box-body">
                          <table id="griditem" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 30px">#</th>
                                    <th>DESCRIÇÃO</th>
                                    <th style="width: 30px">QTD</th>
                                    <th style="width: 40px">UN</th>
                                    <th style="width: 60px">TOTAL</th>
                                    <th width="90px"></th>
                                </tr>
                            </thead>
                            <tr>
                                <tbody>
                                  
                                </tbody>
                            </tr>
                        </table>
                        </div>
                      </div>
                        <div class="row">
                            <div class="col-xs-2">
                                {!!Form::label('codigo', 'Valor total'); !!}
                                {!!Form::text('valortotal', $valortotal, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="row">
    <div class="col-xs-10">
        @include('venda._updatefinanceiroformarecebimento')
    </div>
</div>
<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">ADICIONAL</h3>
                <div class="box-tools pull-right">
                </div>
            </div>
            <div class="box-body">
                <div class="col-xs-12">
                    {!!Form::label('descricao', 'Observação'); !!}
                    {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<div class="modal fade" id="itemVendaModal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Salvar item</h4>
      </div>
     <div id="idPopUpErro" style="display:none; margin-left: 5px; margin-right: 5px" class="callout callout-danger">
        <h4>Atenção!</h4>
        <p></p>
    </div>
    <form method="POST" id="form-item">
      <div class="modal-body">
           @include('template/_aguarde')    
      </div><br>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar (Esc)</button>
        <button type="submit" id="salvarItem" class="btn btn-primary">Salvar (INSERT)</button>
      </div>
    </form>
    </div>
  </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/routes/js/venda/updatevendasimples.js') }}"></script>
    <script src="{{asset('assets/routes/js/venda/updatevendaformarecebimento.js') }}"></script>
@endpush