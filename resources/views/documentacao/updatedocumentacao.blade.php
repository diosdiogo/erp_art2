@extends('layouts.app')

@section('content')
    <div class="box box-danger">
        <div class="box-header with-border">
            <h3 class="box-title">Cadastros</h3>
            <span class="label label-danger pull-right"><i class="fa fa-commenting-o"></i></span>
        </div><!-- /.box-header -->
        <div class="box-body">
            <h4><i class="fa fa-hand-o-right"></i> <b>Grid</b></h4>
            <div class="row">
                <img class="col-sm-12" src="{{url('assets/image/documentacao/gridtemplate.jpg')}}" alt="Mobi" />
            </div>

            <h4><i class="fa fa-hand-o-right"></i> <b>Empresa selecionada</b> (Multi empresa)</h4>
            <div class="row">
                <img class="col-sm-12" src="{{url('assets/image/documentacao/gridtemplate-empresa-selecionada.jpg')}}" alt="Mobi" />
            </div>

            <h4><i class="fa fa-hand-o-right"></i> <b>Tipo de pesquisa</b></h4>
            <div class="row">
                <img class="col-sm-5" src="{{url('assets/image/documentacao/gridtemplate-tipo-pesquisa.jpg')}}" alt="Mobi" />
            </div>

            <h4><i class="fa fa-hand-o-right"></i> <b>Campo de pesquisa</b> </h4>
            <div class="row">
                <img class="col-sm-5" src="{{url('assets/image/documentacao/gridtemplate-campo-pesquisa.jpg')}}" alt="Mobi" />
            </div>


            <h4><i class="fa fa-hand-o-right"></i> <b>Inserir</b> (Atalho F1)</h4>
            <div class="row">
                <img class="col-sm-12" src="{{url('assets/image/documentacao/gridtemplate-inserir.jpg')}}" alt="Mobi" />
            </div>

            <h4><i class="fa fa-hand-o-right"></i> <b>Descricao do grid</b></h4>
            <div class="row">
                <img class="col-sm-12" src="{{url('assets/image/documentacao/gridtemplate-campos.jpg')}}" alt="Mobi" />
            </div>
        </div><!-- /.box-body -->
    </div><!-- /.box -->

@endsection
