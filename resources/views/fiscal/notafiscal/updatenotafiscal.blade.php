@extends('template/updatetemplate')
<link href="{{asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" />
@section('contentInteno')
<input name="idnotafiscalsituacao" value="{{$idnotafiscalsituacao}}" type="hidden"/>
<input name="origemvenda" id="origemvenda" value="{{$origemvenda}}" type="hidden"/>
<div class="row">
    @if($empresas[0]->idambiente == 2)
    <div class="col-xs-12">
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-warning"></i> Alerta</h4>
            <p>A NOTA FISCAL será emitida no ambiente de <strong>HOMOLOGAÇÃO</strong> (SEM VALOR FISCAL).</p>
        </div>
    </div>  
    @endif
</div>
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('id', 'Código'); !!}
        {!!Form::text('id', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
    <div class="col-xs-3">
        {!!Form::label('id', 'Documento de origem'); !!}
        {!!Form::text('numerodocumentoorigem', $numerodocumentoorigem, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>    
    <div class="col-xs-3">
        {!!Form::label('codigo', 'Data Emissão'); !!}
        {!!Form::date('dataemissao', substr($dataemissao, 0, 10), array('class' => 'form-control', ($id > 0 ? 'disabled' : '') => 'disabled'));!!}
    </div>
    <div class="col-xs-3">
        <button type="button" id="btnVisualizarDanfe" style="margin-top: 24px" class="btn btn-primary">Visualização (DANFE)</button>
        <button type="button" id="btnConsultarStatus" style="margin-top: 24px" class="btn btn-primary"><i class="fa fa-search"></i> SEFAZ</button>
    </div>    
    <div class="col-xs-1">
    </div>     
</div>
<div class="row">
    <div class="col-xs-12">
        {!!Form::label('chaveacesso', 'Chave Acesso'); !!}
        {!!Form::text('chaveacesso', $chaveacesso, array('class' => 'form-control', 'placeholder' => 'SEM CHAVE', 'disabled' => 'disabled'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Pessoa</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row"> 
                    <div class="col-xs-12">
                        {!!Form::label('ncm', 'Pessoa (Nome)'); !!}
                        <select id="idpessoa" name="idpessoa" class="form-control select2" style="width: 100%;">
                              @if($descricaoPessoa)
                                <option value="{{$idpessoa}}">{{$descricaoPessoa}}</option>
                            @endif;
                        </select>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-xs-2">
                        {!!Form::label('cep', 'CEP'); !!}
                        {!!Form::text('cep', $cep, array('class' => 'form-control cep', 'placeholder' => 'Digite o cep', 'readonly' => 'readonly'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('logradouro', 'Endereço (Logradouro)'); !!}
                        {!!Form::text('endereco', $endereco, array('class' => 'form-control', 'placeholder' => 'Digite o endereço', 'readonly' => 'readonly'));!!}
                    </div>
                    <div class="col-xs-2">
                        {!!Form::label('numero', 'Numero'); !!}
                        {!!Form::text('numero', $numero, array('class' => 'form-control', 'placeholder' => 'Digite o numero', 'readonly' => 'readonly'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('Complemento', 'Complemento'); !!}
                        {!!Form::text('complemento', $complemento, array('class' => 'form-control', 'placeholder' => 'Digite o complemento', 'readonly' => 'readonly'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('bairro', 'Bairro'); !!}
                        {!!Form::text('bairro', $bairro, array('class' => 'form-control', 'placeholder' => 'Digite o bairro', 'readonly' => 'readonly'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('cidade', 'Cidade'); !!}
                        <select id="idcidade" name="idcidade" class="form-control select2" disabled="disabled" style="width: 100%;">
                            @if($cidadeDescricao)
                                <option value="{{$idcidade}}">{{$cidadeDescricao}}</option>
                            @endif;
                        </select>                            
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('pontoreferencia', 'Ponto de referência'); !!}
                        {!!Form::text('pontoreferencia',  $pontoreferencia, array('class' => 'form-control', 'placeholder' => 'Digite o ponto de referência' , 'readonly' => 'readonly'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('ufs', 'UF'); !!}
                        <select class="form-control select2" readonly id="uf" disabled="disabled" name="iduf" style="width: 100%;">
                            <option value="">[...]</option>
                            @foreach ($UFs as $uf)
                            <option value="{{$uf->id}}" {{$iduf == $uf->id ? 'selected' : ''}}>{{	$uf->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="col-xs-3">
                            <label>Tipo</label>
                            <select class="form-control select2" id="enderecotipo" disabled="disabled" name="idenderecotipo" style="width: 100%;">
                                @foreach ($enderecotipos as $enderecotipo)
                                <option value="{{$enderecotipo->id}}" {{$idenderecotipo == $enderecotipo->id ? 'selected': ''}}>{{$enderecotipo->descricao}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>                
            </div>
        </div>
    </div> 
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Itens (Produto)</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                            @if(!$origemvenda)
                            <button class="btn btn-primary" id="inserirItemNotaFiscal" data-toggle="modal" data-target="#itemNotaFiscalModal" type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                            @endif
                        </div>
                        <div class="box-body">
                          <table id="griditem" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>CÓDIGO</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>UNIDADE</th>
                                    <th>QUANTIDADE</th>
                                    <th>UNITARIO</th>
                                    <th>DESCONTO</th>
                                    <th>CST</th>
                                    <th>CFOP</th>
                                    <th>TOTAL</th>                                                                        
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
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Totais</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-2">
                        {!!Form::label('valortotal', 'Frete (R$)'); !!}<br>
                        {!!Form::text('valorfrete', $valorfrete, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                    </div>
                    <div class="col-xs-2">
                        {!!Form::label('valortotal', 'Seguro (R$)'); !!}<br>
                        {!!Form::text('valorseguro', $valorseguro, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                    </div>
                    <div class="col-xs-2">
                        {!!Form::label('valortotal', 'Desconto (R$)'); !!}<br>
                        {!!Form::text('valordesconto', $valordesconto, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                    </div>                    
                    <div class="col-xs-2">
                        {!!Form::label('valortotal', 'Outras Despesas (R$)'); !!}<br>
                        {!!Form::text('valoroutras', $valoroutras, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                    </div>                    
                    <div class="col-xs-4">
                        {!!Form::label('valortotal', 'Total (R$)'); !!}<br>
                        {!!Form::text('valortotal', $valortotal, array('class' => 'form-control money', 'readonly' => 'readonly'));!!}
                    </div>
                </div>   
            </div>
        </div>
    </div> 
</div>
{{-- <div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Imposto</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                  
                </div>   
            </div>
        </div>
    </div> 
</div> --}}
<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Informação adicional</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        {!!Form::label('tipo', 'Observação'); !!}<br>
                        {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}
                    </div>
                </div>   
            </div>
        </div>
    </div> 
</div>
</form>
<div class="modal fade" id="itemNotaFiscalModal" role="dialog" aria-labelledby="myModalLabel">
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
    <script src="{{asset('assets/routes/js/fiscal/notafiscal/gridnotafiscal.js') }}"></script>
    <script src="{{asset('assets/routes/js/fiscal/notafiscal/updatenotafiscal.js') }}"></script>
    <script src="{{asset('assets/routes/js/fiscal/notafiscal/updatenotafiscalutilitario.js') }}"></script>
@endpush