<html>
    <head>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link href="{{url('/assets/dist/css/mobi.relatorio.css') }}" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{url('assets/image/logo-mobi-mini.png')}}"/>
        @stack('script-head')
    </head>
    <body>
        @yield('content')
    </body>    
    @stack('scripts')
</html>
