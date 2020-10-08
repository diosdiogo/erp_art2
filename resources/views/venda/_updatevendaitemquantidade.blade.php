@if($quantidadeQuadrado > 1)
  @for ($i = 1; $i <= $quantidadeQuadrado; $i++)
      <div class="col-xs-4">
          {!!Form::label("quantidade_$i", "Quantidade $i"); !!}
          @if(isset($quantidadeRealQuadrado[$i - 1]) && $quantidadeRealQuadrado[$i - 1] > 0)
            {!!Form::text("quantidade_$i", $quantidadeRealQuadrado[$i - 1], array('class' => 'form-control quantidadeQuadradoClass trescasasdecimais', 'required' => 'required'));!!}
          @else
            {!!Form::text("quantidade_$i", 0, array('class' => 'form-control quantidadeQuadradoClass trescasasdecimais', 'required' => 'required'));!!}
          @endif
          <script>
               setTimeout(function(){
                  $("#quantidade_{{$i}}").on("change",  $.namespace('updatevendaitemsimples').alterarQuatidadeQuadradoTexto);
                  $("#quantidade_{{$i}}").on("keypress",  $.namespace('updatevendaitemsimples').alterarQuatidadeQuadradoTexto);
               }, 300);
          </script>
      </div> 
  @endfor
@endif 