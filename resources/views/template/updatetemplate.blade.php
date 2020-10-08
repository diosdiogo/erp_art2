@extends('layouts.app')
@push('script-head')
<link href="{{asset('assets/plugins/iCheck/all.css') }}" rel="stylesheet" />
<link href="{{asset('assets/dist/css/sweetalert.css') }}" rel="stylesheet" />
<link href="{{asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{asset('assets/dist/css/mobi.cadastro.css') }}" rel="stylesheet" />
@endpush
@section('content')
		<form class="form-horizontal" id="formPrincipal" role="form" method="POST" action="{{url('/'. $rotaAcao .'/'. $acao) }}">
            <input name="_method" value="POST" type="hidden"/>
            <input id="action" value="{{$action}}" type="hidden"/>
            <input id="idempresa" name="idempresa" value="{{$idempresa}}" type="hidden"/>            
            <div class="row" style="margin-top: -20px">
                <div class="col-xs-9">
                    <div class="navbar navbar-static-top fixed fixed nav-opcoes">
                        <button id="btnSalvar" class="btn btn-primary">Salvar</button> ou 
                        <a class="btnCancelar" href="{{url('/'. $rotaAcao . "/concluiredicao/" . ($id == '0' ? '' : $id))}}">Cancelar</a>
                    </div>
                </div> 
            </div><br /><br />
			<div class="box-body">
				{{csrf_field() }}
                <div class="row">
                    <div class="col-xs-10">
                        @include('template/updatetemplate-erros')
                    </div>
                </div>
                    @yield('contentInteno')
                </div>
		</form>
@endsection

@push('scripts')
<script src="{{asset('assets/dist/js/updatetemplateall.js') }}"></script>
<script src="{{asset('assets/dist/js/updatetemplate.js') }}"></script>  
@endpush