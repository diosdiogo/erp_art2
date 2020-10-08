<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{$configuracao->nomesistema}}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{ asset('assets/dist/css/mainAll.min.css') }}" rel="stylesheet" />
    @stack('script-head')
    <link href="{{url('/assets/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
    <link href="{{url('/assets/dist/css/mobi.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/png" href="{{url('assets/image/logo-mobi-mini.png')}}"/>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="skin-blue sidebar-mini {{$minimizarMenu or 0 ? 'pace-done pace-done sidebar-collapse' : ''}} ">
    <div class="wrapper">
        <header class="main-header">
            <a href="/home" class="logo">
                <span class="logo-mini">
                    <b>
                        <img src="{{url('assets/image/logo-mobi-mini.png')}}" alt="Mobi" height="35" width="50" />
                    </b>
                </span>
                <span class="logo-lg">
                    <img src="{{url('assets/image/logo-mobi.png')}}" alt="Mobi" height="50" width="120" />
                </span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li style="display:none" class="nav_venda">
                            <a href="{{url('/venda/inserir')}}">
                                <i class="fa ion ion-bag"></i> 
                                <b class="hidden-xs">NOVA VENDA</b>
                            </a>
                        </li>   
                        <li style="display:none" class="nav_venda">
                            <a href="{{url('/home')}}">
                                <i class="fa fa-retweet"></i> 
                                <b class="hidden-xs">SAIR DO PDV</b>
                            </a>
                        </li>                                                
                        <li class="nav_comum">
                            <a href="{{url('/vendasimples/inserir')}}">
                                <i class="ion ion-bag"></i> 
                                <b class="hidden-xs"> VENDA</b>
                            </a>
                        </li>
                        <li class="nav_comum">
                            <a href="{{url('/venda/inserir')}}">
                                <i class="fa fa-desktop"></i> 
                                <b class="hidden-xs"> PDV</b>
                            </a>
                        </li>                        
                        <li class="nav_comum">
                            <a href="{{url('/financeirolancamento')}}">
                                <i class="glyphicon glyphicon-piggy-bank"></i>
                            </a>
                        </li>                        
                        <li class="nav_comum">
                            <a id="btnSuporteOnline" href="#">
                                <i class="fa fa-comments-o"></i>
                            </a>
                        </li>
                        <li class="dropdown messages-menu nav_comum">
                       <!-- <li id="dropdown-busca" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search"></i></a>
                            <ul class="dropdown-menu">
                                <li style="width:350px" class="pad">
                                <input type="text" placeholder="BUSCAR ROTINA" class="form-control select2" id="buscar_menu" name="search" id="search-input" />
                                </li>
                                <li>
                                <div id='results'>
                                  
                                </div>
                                </li>
                            </ul>
                            </li> -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">{{$notificacaoContador}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Você tem {{$notificacaoContador}} mensagens</li>
                                <li>
                                    <ul class="menu">
                                        @include("notificacao/_notificacao")
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="{{url('notificacao')}}">Ver todas</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown user user-menu nav_comum">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{url('assets/image/logo/'. Auth::user()->imagem .'.jpg')}}" class="user-image" alt="User Image" />
                                <span class="hidden-xs">{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="{{url('assets/image/logo/'. Auth::user()->imagem .'.jpg')}}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{ Auth::user()->name }}
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{url('minhaconta')}}" class="btn btn-default btn-flat">Minha conta</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sair</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar" style="background-color: #222d32;">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{url('assets/image/logo/'. Auth::user()->imagem .'.jpg')}}" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>{{Auth::user()->name }}</p>
                        <a href="#">
                            <i class="fa fa-circle text-success"></i>Online
                        </a>
                    </div>
                </div>
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                      <input type="text" name="q" class="form-control" placeholder="Buscar...">
                          <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                            </button>
                          </span>
                    </div>
                </form>
                <ul class="sidebar-menu">
                    <li class="header">MENU</li>
                    <li class="active">
                        <a href="/home">
                            <i class="fa fa-book"></i>
                            <span>INICIO</span>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-plus"></i>
                            <span>CADASTROS</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/empresa')}}">
                                    <i class="fa  fa-sitemap"></i>EMPRESA
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-users"></i>PESSOAS
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{url('/pessoa')}}">
                                            <i class="fa fa-users"></i>PESSOA
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/pessoaramoatividade')}}">
                                            <i class="fa fa-suitcase"></i>RAMO ATIVIDADE
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-bars"></i>PRODUTO
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{url('/produto')}}">
                                            <i class="fa fa-archive"></i>PRODUTO
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/produtocategoria')}}">
                                            <i class="fa fa-tag"></i>CATEGORIA
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/produtomarca')}}">
                                            <i class="fa fa-spinner"></i>MARCA
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/produtoregrafiscal')}}">
                                            <i class="fa fa-legal"></i>REGRA FISCAL
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/produtopreco')}}">
                                            <i class="fa fa-money"></i>PREÇO
                                        </a>
                                    </li>                                    
                                </ul>
                            </li>
                            <li>
                                <a href="{{url('/transportadora')}}">
                                    <i class="fa fa-truck"></i>TRANSPORTADORA
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{--  <li class="treeview">
                        <a href="#">
                            <i class="fa fa-ticket"></i>
                            <span>PRODUÇÃO</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/producaomaquina')}}">
                                    <i class="fa fa-television"></i>MÁQUINA
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/producaocontrole')}}">
                                    <i class="fa fa-circle"></i>CONTROLE DE PRODUÇÃO
                                </a>
                            </li>                                
                        </ul>
                    </li>  --}}
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-asterisk"></i>
                            <span>PARAMETROS</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/parametrofinanceiro')}}">
                                    <i class="fa fa-users"></i>FINANCEIRO
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/parametromercadoria')}}">
                                    <i class="fa fa-archive"></i>MERCADORIA
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/parametrofaturamento')}}">
                                    <i class="fa fa-cc-visa"></i>FATURAMENTO
                                </a>
                            </li>                              
                            <li>
                                <a href="{{url('/parametrofiscal')}}">
                                    <i class="fa fa-gg"></i>FISCAL
                                </a>
                            </li>                            
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-bars"></i>
                            <span>VENDAS</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/vendasimples')}}">
                                    <i class="fa ion-bag"></i>PEDIDOS (SIMPLES)
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/venda')}}">
                                    <i class="fa ion-bag"></i>PEDIDOS 
                                </a>
                            </li>
                        </ul>                        
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-calculator"></i>
                            <span>FINANCEIRO</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-bars"></i>TABELAS
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                                                        <li>
                                      <a href="#"><i class="fa fa-windows"></i> PAGAMENTOS 
                                        <span class="pull-right-container">
                                          <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                      </a>
                                      <ul class="treeview-menu">
                                        <li>
                                            <a href="{{url('/financeiroformarecebimento')}}">
                                            <i class="fa fa-table"></i>FORMA DE PAGAMENTO
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/financeiroformarecebimentotipo')}}">
                                                <i class="fa fa-credit-card"></i>TIPO ESPÉCIE
                                            </a>
                                        </li>
                                      </ul>
                                    </li>
                                    <li>
                                        <a href="{{url('/financeiroconta')}}">
                                            <i class="fa fa-credit-card"></i>CONTA CORRENTE
                                        </a>
                                    </li>
                                    <li>
                                      <a href="#"><i class="fa fa-windows"></i> CONTAS GERENCIAIS
                                        <span class="pull-right-container">
                                          <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                      </a>
                                      <ul class="treeview-menu">
                                        <li>
                                            <a href="{{url('/financeirocontagerencial')}}">
                                                <i class="fa fa-credit-card"></i>CONTA GERENCIAL
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('/financeirocontagerencialdemonstrativo')}}">
                                                <i class="fa fa-credit-card"></i>CONTA GERENCIAL TIPO
                                            </a>
                                        </li>
                                      </ul>
                                    </li>
                                    <li>
                                        <a href="{{url('/financeirobanco')}}">
                                            <i class="fa fa-credit-card"></i>BANCO
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{--  <li>
                                <a href="{{url('/')}}">
                                    <i class="glyphicon glyphicon-usd"></i>FLUXO DE CAIXA
                                </a>
                            </li>  --}}
                             <li>
                                <a href="{{url('/financeirolancamento')}}">
                                    <i class="glyphicon glyphicon-piggy-bank"></i>MOVIMENTAÇÃO CAIXA
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/financeirocontapagar')}}">
                                    <i style="color:red" class="fa fa-money"></i>CONTAS A PAGAR
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/financeirocontareceber')}}">
                                    <i style="color:green" class="fa fa-money"></i>CONTAS A RECEBER
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-shield"></i>
                            <span>FISCAL</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>

                        <ul class="treeview-menu">
                            <li>
                                <a href="#">
                                    <i class="fa fa-bars"></i>TABELAS
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li>
                                        <a href="{{url('/fiscalncm')}}">
                                            <i class="fa fa-table"></i>NCM
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{url('/fiscalcest')}}">
                                            <i class="fa fa-qrcode"></i>CEST
                                        </a>
                                    </li>                                    
                                    <li>
                                        <a href="{{url('/fiscalcfop')}}">
                                            <i class="fa fa-trademark"></i>CFOP
                                        </a>
                                    </li>                                     
                                </ul>
                            </li>
                            <li>
                                <a href="{{url('/notafiscal')}}">
                                    <i class="fa fa-lock"></i>NOTA FISCAL
                                </a>
                            </li>
                            <li>
                                <a href="{{url('/fiscalnaturezaoperacao')}}">
                                    <i class="fa fa-lock"></i>NATUREZA DE OPERAÇÃO
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-user-secret"></i>
                            <span>USUARIO</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/usuario')}}">
                                    <i class="fa fa-user"></i>USUÁRIO
                                </a>
                            </li>                        
                            {{--  <li>
                                <a href="{{url('/')}}">
                                    <i class="fa fa-lock"></i>PERMISSÕES
                                </a>
                            </li>  --}}
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-pie-chart"></i>
                            <span>RELATÓRIO</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/relatoriovenda')}}">
                                    <i class="fa ion-bag"></i>VENDAS
                                </a>
                            </li>
                        </ul>                        
                    </li>  
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-line-chart"></i>
                            <span>GRÁFICOS</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{url('/graficovenda')}}">
                                    <i class="fa ion-bag"></i>VENDAS
                                </a>
                            </li>
                        </ul>                        
                    </li>                                      
                    <li class="header">INFORMAÇÃO</li>
                    <li>
                        <a href="{{url('/documentacao')}}">
                            <i class="fa fa-circle-o text-aqua"></i>
                            <span>DOCUMENTAÇÃO</span>
                        </a>
                    </li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <ol class="breadcrumb">
                    <li>
                        <a href="/home">
                            <i class="fa fa-home"></i>Home
                        </a>
                    </li>
                    {!! $rota or "
                    <li class='active'>Dashboard</li>" !!}
                </ol>
            </section>
            <section class="content">
                @yield('content')
            </section>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Versão</b> {{$configuracao->versao}}
            </div>
            <strong>
                Copyright &copy; 2017
                <a target="_blank" href="{{$configuracao->site}}">{{$configuracao->nomesistema}}</a>.
            </strong>All rights
    reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs"></ul>
            <div class="tab-content">
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class="control-sidebar-menu"></ul>
                </div>
                <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            </div>
        </aside>
        <div class="control-sidebar-bg"></div>
    </div>

    <script src="{{asset('assets/dist/js/initall.min.js') }}"></script>
    <script src="{{asset('assets/dist/js/common.js') }}"></script>
    <script src="{{asset('assets/dist/js/mobi.notificacao.js') }}"></script>
    <script> $("#btnSuporteOnline").on("click", function () {Tawk_API.toggle();});</script>
    @stack('scripts')
</body>
</html>