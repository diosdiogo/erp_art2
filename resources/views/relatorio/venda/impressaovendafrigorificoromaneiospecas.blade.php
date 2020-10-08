@extends('template/updaterelatorio')
@section('content')
            <div style="padding: -20px;margin-left:7px"><b><h2>FRIGORIFICO</h2></b></div>
            <div style="padding: -20px;margin-left:7px"><p>[TIPO] RELÁTORIO DE ROMANEIOS TOTALIZADO PARA PEÇAS</p></div>            
            <div style="padding: -20px;margin-left:7px; margin-top:7px"><p><b>{{date('d/m/Y')}}</b></p></div>     
            <div style="padding: -20px;margin-left:7px; margin-top:7px"><p><b>TRANSPORTE:</b> {{$descricaotransportadora or 'TODOS'}}</p></div>            
            <div style="padding: -20px;margin-left:7px; margin-top:7px"><p><b>PERÍODO:</b> {{date_format(date_create($dataInicial), 'd/m/Y')}} a {{date_format(date_create($dataFinal), 'd/m/Y')}}</p></div>            

<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
<table style="width:100%">
  <tr>
    <th align="left">CÓDIGO</th>
    <th align="left">DESCRIÇÃO</th> 
    <th align="left">SIGLA</th>
    <th align="left">QUANTIDADE</th> 
    <th align="left">PC</th>
  </tr>
@foreach($produtos as $item)
  <tr>
    <td>{{$item->idproduto}}</td>
    <td>{{$item->codigoreduzido}}</td>
    <td>{{$item->descricao}}</td>
    <td>{{number_format($item->quantidade, 2, '.', '')}}</td>
    <td>{{strtoupper($item->unidade)}}</td>
  </tr>
@endforeach
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
  </tr>
</table>
<br>    
<div style="padding: -20px;margin-left:7px; margin-top:7px"><p>Totalização geral de peças................................................: {{$quantidadetotalpecas}}</p></div>
<div style="padding: -20px;margin-left:7px; margin-top:7px"><p>Totalização geral de caixas...............................................: {{$quantidadetotalcaixas}}</p></div>            
@endsection 