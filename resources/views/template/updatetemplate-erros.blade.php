<br>
<div class="row">
    <div id="divErros" class="col-xs-12" style="margin-bottom: -15px">
        @if (count($errors) > 0)
        <div class="callout callout-danger bg-red disabled color-palette">
            <h4>Alerta!</h4>
            <div id="erros" hidden data='{!! json_encode(array_keys($errors->default->messages())) !!}'></div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>
