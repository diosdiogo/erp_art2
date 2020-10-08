@forelse($notificacaoes as $notificacao)
    <li>
        <a href="#">
            <div class="pull-left">
                <h4><i class="img-circle fa fa-envelope-o"></i></h4>
            </div>
            <h4>
                {{$notificacao->titulo}}
            </h4>
            <p>{{$notificacao->texto}}</p>
        </a>
    </li>
@empty
<center><p>Sem notificação</p></center>
@endforelse