<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mobi Soft</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{asset('assets/dist/css/AdminLTE.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/dist/css/mobi.css') }}" rel="stylesheet" />
  <link href="{{asset('assets/plugins/iCheck/square/blue.css') }}" rel="stylesheet">
<link rel="icon" type="image/png" href="{{url('assets/image/logo-mobi-mini.png')}}"/>
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition login-page login-bg">
    <div class="login-box">
        <div class="login-box-body">
            <div class="login-logo">
                <img src="{{url('assets/image/logo-mobi.png')}}" alt="Mobi" height="80" width="160" />
            </div>
            <p class="login-box-msg">Faça login para começar a sua sesão</p>
            <form action="{{ url('/login') }}" role="form" method="POST">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" />
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback">
                    <input id="password" name="password" type="password" class="form-control" placeholder="Senha" />
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                    </div>
                </div>
            </form>

            <!--<a href="#">Esqueci minha senha</a>-->
            <br />

        </div>
        <br>
        @if(isset($mensagem))
            <div class="callout callout-info" style="margin-bottom: 0!important;">
                <h4><i class="fa fa-info"></i> Atenção!</h4>
                {{isset($mensagem) ? $mensagem : ""}}
            </div>
        @endif
    </div>
    <script src="{{ asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/iCheck/icheck.min.js') }}"></script>

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>
</html>
