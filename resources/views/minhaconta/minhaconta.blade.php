@extends('layouts.app')
@push('script-head')
@endpush

@section('content')
<div class="col-md-12">
    <div class="box box-widget widget-user">
        <div class="widget-user-header bg-blue">
            <center><h3 class="widget-user-username">{{Auth::user()->name }}</h3></center>
        </div>
        <div class="widget-user-image">
            <img class="img-circle" src="{{url('/assets/image/logo/'.Auth::user()->imagem.'.jpg')}}" alt="Usuario">
        </div>
        <div class="box-footer">
            <div class="row">
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <label>
                            ATIVO<br /> {!!Form::CheckBox('supervisor', false, Auth::user()->ativo, array('class' => 'description-header flat-red', 'disabled' => 'disabled')) !!}
                        </label>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-4 border-right">
                    <div class="description-block">
                        <label>
                            SUPERVISOR<br /> {!!Form::CheckBox('supervisor', false, Auth::user()->supervisor, array('class' => 'description-header flat-red', 'disabled' => 'disabled')) !!}
                        </label>
                    </div>
                    <!-- /.description-block -->
                </div>
                <div class="col-sm-4">
                    <div class="description-block">
                        <label>
                            CODIGO<br /> {{Auth::user()->id}}
                        </label>
                    </div>
                    <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <br />
                <br />
                <br />
                <br />
                <br />
                <br />
            </div>
            <!-- /.row -->
        </div

        {{-- @if(Auth::user()->supervisor)
            <div class="box-footer no-padding">
                  <ul class="nav nav-stacked">
                    <li><a href="#">Quantidade maxima de usuario: <span class="pull-right badge bg-blue">{{$empresaFilial->quantidadeusuario}}</span></a></li>
                    <li><a href="#">Bloqueio financeiro: <span class="pull-right badge bg-blue">{{$empresaFilial->bloqueiofinanceiro}}</span></a></li>
                  </ul>
                </div>
        @endif --}}
    </div>

    <!-- /.widget-user -->
</div>
</div>
@endsection

@push('scripts')

@endpush
