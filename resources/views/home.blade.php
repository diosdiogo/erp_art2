@extends('layouts.app')
@push('script-head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<link href="{{url('/assets/plugins/morris/morris.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><i class="fa fa-credit-card"></i></h3>
                <b>
                    <p>VENDA</p>
                </b>
            </div>
            <div class="icon">
                <i class="ion ion-bag"></i>
            </div>
            <a href="{{url('/vendasimples')}}" class="small-box-footer">
                <i class="fa fa-arrow-circle-right"></i> Atalho (CTRL+1)
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">

                <h3><i class="ion ion-pie-graph"></i></h3>
                <b>
                    <p><span>RELATORIO</span></p>
                </b>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{url('/relatoriovenda')}}" class="small-box-footer">
                <i class="fa fa-arrow-circle-right"></i> Atalho (CTRL+2)
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{$quantidadePessoa or '0'}}</h3>

                <b><p>PESSOA</p></b>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>
            <a href="{{url('/pessoa')}}" class="small-box-footer">
                
                <i class="fa fa-arrow-circle-right"></i> Atalho (CTRL+3)
            </a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{$quantidadeProduto or '0'}}</h3>
                <b>
                    <p>PRODUTO</p>
                </b>
            </div>
            <div class="icon">
                <i class="fa fa-archive"></i>
            </div>
            <a href="{{url('/produto')}}" class="small-box-footer">
                <i class="fa fa-arrow-circle-right"></i> Atalho (CTRL+4)
            </a>
        </div>
    </div>
</div>
<div class="row">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Movimentacao caixa</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive"><br>
              <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
              <br><br><br><br><br><br>
            </div>
          </div>
        </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Facilitadores</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
            <div class="margin">
                <p style="margin-left:10px"><b>PESSOAS</b></p>
                <a href="{{url('/pessoa')}}" class="btn btn-app">
                    <i class="fa fa-users"></i> PESSOA
                </a>
                <a href="{{url('/pessoaramoatividade')}}" class="btn btn-app">
                    <i class="fa fa-suitcase"></i> RAMO DE ATIVIDADE
                </a>
            </div>
            <div class="margin">
                <p style="margin-left:10px"><b>PRODUTOS</b></p>
                <a href="{{url('/produto')}}" class="btn btn-app">
                    <i class="fa fa-archive"></i> PRODUTO
                </a>
                <a href="{{url('/produtocategoria')}}" class="btn btn-app">
                    <i class="fa fa-tag"></i> CATEGORIA
                </a>
                <a href="{{url('/produtomarca')}}" class="btn btn-app">
                    <i class="fa fa-spinner"></i> MARCA
                </a>
            </div>
            <div class="margin">
                <p style="margin-left:10px"><b>PARAMETROS</b></p>
                <a href="{{url('/parametrofinanceiro')}}" class="btn btn-app">
                    <i class="fa fa-users"></i> FINANCEIRO
                </a>
                <a href="{{url('/parametromercadoria')}}" class="btn btn-app">
                    <i class="fa fa-archive"></i> MERCADORIA
                </a>
            </div>
            <div class="margin">
                <p style="margin-left:10px"><b>FINANCEIRO</b></p>
                <a href="{{url('/financeirolancamento')}}" class="btn btn-app">
                    <i class="fa fa-users"></i> MOVIMENTACAO CAIXA
                </a>
                <div class="btn-group">
                      <button type="button" class="btn btn btn-app"><i class="fa fa-bars"></i> TABELAS</button>
                      <button type="button" class="btn btn btn-app dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{url('/financeiroformarecebimento')}}">
                                <i class="fa fa-table"></i>FORMA DE PAGAMENTO
                            </a>
                        </li>
                        <li>
                            <a href="{{url('/financeiroconta')}}">
                                <i class="fa fa-credit-card"></i>CONTA CORRENTE
                            </a>
                        </li>
                      </ul>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/plugins/morris/morris.min.js') }}"></script>

<script>
var receita = ('{{$dashboardMovimentacao['receita']}}').replace(',', '.');
var despesa = ('{{$dashboardMovimentacao['despesa']}}').replace(',', '.');
var total = ('{{$dashboardMovimentacao['total']}}').replace(',', '.');

var donut = new Morris.Donut({
    element: 'sales-chart',
    resize: true,
    colors: ["#00a65a", "#dd4b39", "#00c0ef"],
    data: [
        {label: "Receita", value: receita},
        {label: "Despesa", value: despesa},
        {label: "Total", value: total}
    ],
    formatter: function (x) { return 'R$ ' + parseFloat(x).format() },
    hideHover: 'auto'
});
</script>
@endpush