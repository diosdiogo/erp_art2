@extends('layouts.app')
@push('script-head')
	<style>
		.select2-container--default .select2-selection--single, .select2-selection .select2-selection--single{height: 51px !important; font-size: 28px !important;}.content{ background: #f4f4f4 !important}
		.main-footer{display: none}.skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side{background: #f9f9f9 !important; margin-left: -45px}
		.content-wrapper{background: #f4f4f4 !important}html{background: #f4f4f4 !important}#griditem{height: 380px;}
		.form-control { height: 51px !important; font-size: 28px !important}.nav_venda{display:block !important}.nav_comum{display:none !important} .content-header{display:none;}.main-sidebar{display:none;}.sidebar-mini .content-wrapper, .sidebar-mini .right-side, .sidebar-mini .main-footer {margin-left: -50px !important;z-index: 840;}.sidebar-toggle{display:none;}
		@media (max-width: 1024px) {
			.tablet-esconder {
					display:none!important
			}
			.botoesAcao {
				margin-top:-20px
			}
		}
	</style>
	<link href="{{asset('assets/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/iCheck/all.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/dist/css/mobi.cadastro.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/dist/css/custom.css') }}" rel="stylesheet" />
		<link href="{{asset('assets/dist/css/sweetalert.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/dist/css/iziToast.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<form id="formPrincipal" role="form" method="POST" action="{{url('/'. $rotaAcao .'/'. $acao) }}">
<input name="_method" value="POST" type="hidden"/>
<input id="action" value="{{$action}}" type="hidden"/>
<a class="btnCancelar" href="{{url('/'. $rotaAcao .'/concluiredicao/'. ($id > 0 ? $id : ''))}}" type="hidden"/></a>
{{csrf_field() }}
<input type="text" name="idpessoavendedor" value="1" hidden>
<input type="text" name="faturar" value="0" hidden>
<div class="row">
		<div class="col-xs-10">
				@include('template/updatetemplate-erros')
		</div>
</div>
<div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">OPERADOR:</span>
              <span class="info-box-number">{{Auth::user()->name}}</span>
            </div>
          </div>
    </div>
	<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-clock-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">DATA:</span>
              <span class="info-box-number">{{date("d/m/Y")}}</span>
            </div>
          </div>
    </div>
	<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-money"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">TOTAL:</span>
              <span class="info-box-number totalPagar">R$ 0,00</span>
            </div>
          </div>
    </div>	
	<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-exclamation"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">STATUS:</span>
              <span class="info-box-number">{{$id == 0 ? 'NOVO' : ($idvendasituacao == 1 ?  'ABERTA' : 'FECHADO')}}</span>
            </div>
          </div>
    </div>		
</div>
<div class="row">
	<div class="col-md-6 col-sm-6 col-xs-12">
		<div class="row">
			<div class="col-xs-12">
				{!!Form::label('produto_label', 'PRODUTO (F1)'); !!}
				<select id="idproduto" name="idproduto" class="form-control" style="width: 100%;">
				</select>
			</div>
		</div>
		<div class="row" style="margin-top:5px;margin-left:-25px">
			<div>
				<div class="col-xs-12">
						<button type="button" id="btnObservacao" class="btn btn-app">
								<i class="fa fa-file-text-o"></i> OBSERVAÇÃO (F6)
						</button>
						<button type="button" id="btnDataVenda" class="btn btn-app">
								<i class="fa fa-clock-o"></i>  DATA (F7)
						</button>									
				</div>
			</div>
		</div><br><br><br><br><br>
		<div class="row">
			<div class="col-xs-4">
				{!!Form::label('descricao', 'QUANTIDADE'); !!}
				{!!Form::number('quantidade', '1', array('class' => 'form-control', 'placeholder' => 'QUANTIDADE'));!!}
			</div>			
			<div class="col-xs-4">
				{!!Form::label('descricao', 'DESCONTO (R$)'); !!}
				{!!Form::text('descontomoeda', '0', array('class' => 'form-control money', 'placeholder' => 'DESCONTO', 'disabled' => 'disabled'));!!}
			</div>
			<div class="col-xs-4">
				{!!Form::label('descricao', 'ACRÉSCIMO (R$)'); !!}
				{!!Form::text('acrescimomoeda', '0', array('class' => 'form-control money', 'placeholder' => 'ACRÉSCIMO', 'disabled' => 'disabled'));!!}
			</div>						
		</div>
		<div class="row"><br>
			<div class="col-xs-12">
				<div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">FORMAS DE PAGAMENTO (FECHAR)</h3>
            </div>
            <div class="box-body">
              <a class="btn btn-app">
                <i class="fa fa-money"></i> DINHEIRO (F10)
              </a>
             <!-- <a class="btn btn-app">
                <i class="fa fa-credit-card"></i> CARTÃO
              </a>
              <a class="btn btn-app">
                <i class="fa fa-list-alt"></i> CHEQUE
              </a>-->
            </div>
          </div>				
			</div>			
		</div><br><br><br>
		<div class="row" class="botoesAcao">
			<div class="col-xs-12">			
				<div class="col-xs-3">
					<button type="button" id="btnInserir" class="btn btn-primary btn-lg"><span class="tablet-esconder">(INSERT)</span> INSERIR</button>
				</div>
				<div class="col-xs-3">
					<button type="button" id="btnFechar" class="btn btn-primary btn-lg"><span class="tablet-esconder">(F10)</span> FECHAR</button>
				</div>
				<div class="col-xs-3">
					<button type="submit" id="btnSalvar" class="btn btn-primary btn-lg"><span class="tablet-esconder">(F9)</span> SALVAR</button>
				</div>																									
				<div class="col-xs-3">
					<button type="button" id="btnCancelar" class="btn btn-primary btn-lg"><span class="tablet-esconder">(F2)</span> CANCELAR</button>
				</div>			
			</div>
		</div>
	</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="col-xs-12" style="margin-bottom:5px">
					{!!Form::label('produto_label', 'PESSOA (F4)'); !!}
					<select class="form-control select2" id="idpessoa" name="idpessoa" style="width: 100%;">
						<option value="">[SELECIONE]</option>
						@foreach ($clientes as $cliente)
							<option value="{{$cliente->id}}" {{$idpessoa == $cliente->id ? 'selected' : ''}}>{{($cliente->codigopesonalizado ? $cliente->codigopesonalizado : $cliente->id) .' - ' . $cliente->nomefantasia}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="box box-primary">
									<div class="box-header with-border">
									</div>
									<div class="box-body no-padding">
									<div class="table-responsive mailbox-messages">
										<table id="griditem" class="table table-bordered table-hover">
											<thead>
												<tr>
													<th>#</th>
													<th width="550px">DESCRIÇÃO</th>
													<th>QTD</th>
													<th>UN</th>
													<th>TOTAL</th>
													<th width="30px"></th>
												</tr>
											</thead>
											<tr>
											</tr>
										</table>
									</div>
									</div>
									<!-- /.box-body -->
							<div class="box-footer bg-blue">
								<div class="row">
									<div class="col-xs-5">
										<p style="font-size: 20px;weight: bold;"><strong>ITENS: <span id="totalItens">0</span></strong></p>
									</div>
									<div class="col-xs-5">
										<p style="font-size: 20px;weight: bold;"><strong>D: <span id="spanDesconto">R$ 0,00</span></strong></p>
									</div>
									<div class="col-xs-2">
										<p style="font-size: 20px;weight: bold;"><strong>A: <span id="spanDesconto">R$ 0,00</span></strong></p>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-10">
										<p style="font-size: 20px;weight: bold;"><strong>TOTAL</strong></p>
									</div>
									<div class="col-xs-2">
										<p style="font-size: 20px;weight: bold;" class="totalPagar">R$ 0,00</p>
									</div>
							</div>											
							</div>
							</div>				
					</div>
				</div>		
			</div>	
<div class="modal fade" id="itemFormaRecebimento" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
     <div id="idPopUpErro" style="display:none; margin-left: 5px; margin-right: 5px" class="callout callout-danger">
        <h4>Atenção!</h4>
        <p></p>
    </div>
    <div id="form-item">
      <div class="modal-body">
           @include('venda/_updatefinanceiroformarecebimento', array('idformarecebimento' => '1'))
					 <div class="row">
							<div class="col-xs-12">
								<a class="btn btn-block btn-social btn-bitbucket">
                 		<i class="fa fa-money"></i><span class="info-box-number totalPagar">R$ 0,00</span>
              	</a>
							</div>
					</div>		
					 <br>
					<div class="row">
					 
						<div class="col-xs-4">
								{!!Form::label('descricao', 'RECEBIDO (R$)'); !!}
								{!!Form::text('valorrecebido', '0', array('class' => 'form-control', 'disabled' => 'disabled','placeholder' => 'VALOR RECEBIDO'));!!}
						</div>		
						<div class="col-xs-4">
								{!!Form::label('descricao', 'TROCO (R$)'); !!}
								{!!Form::text('valortroco', '0', array('class' => 'form-control', 'disabled' => 'disabled','placeholder' => 'TROCO'));!!}
						</div>	
						<div class="col-xs-4">
								{!!Form::label('descricao', 'A RECEBER (R$)'); !!}
								{!!Form::text('valorareceber', '0', array('class' => 'form-control', 'disabled' => 'disabled','placeholder' => 'A RECEBER'));!!}
						</div>											
					</div>
					 <br><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        <button id="salvarFormaRecebimento" class="btn btn-primary">Salvar (END)</button>
      </div>
    </div>
    </div>
  </div>
</div>
	<div class="modal fade" id="itemDataVenda" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
						<label for="codigo">Data venda</label>
						<input class="form-control" name="datavenda" type="date" value="{{$datavenda}}">
						<label for="codigo">Data entrega</label>
						<input class="form-control" name="dataentrega" type="date" value="{{$dataentrega}}">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Salvar (Esc)</button>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="itemObservacao" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
						{!!Form::label('descricao', 'Observação'); !!}
						<textarea name="observacao" id="observacao" rows="15" cols="90">{{$observacao}}</textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Salvar (Esc)</button>
				</div>
			</div>
		</div>
	</div>	
</form>


@endsection
@push('scripts')
@if(Session::has('idModeloInserido'))
	<script>
		var id = '{{Session::get("idModeloInserido")}}'; 
		window.open("/vendasimples/imprimir?id=" + id, "_blank");
	</script>
@endif

	<script src="{{asset('assets/dist/js/updatetemplateall.js') }}"></script>
	<script src="{{asset('assets/dist/js/updatetemplate.js') }}"></script>
	<script src="{{asset('assets/dist/js/iziToast.min.js') }}"></script>
	<script src="{{asset('assets/routes/js/venda/updatevenda.js') }}"></script>
	<script src="{{asset('assets/routes/js/venda/updatevendaformarecebimento.js') }}"></script>
@endpush
