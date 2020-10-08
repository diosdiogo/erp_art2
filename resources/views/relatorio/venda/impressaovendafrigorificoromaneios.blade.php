@extends('template/updaterelatorio')
@section('content')
            <div style="padding: -20px;margin-left:7px"><b><h2>FRIGORIFICO</h2></b></div>
            <div style="padding: -20px;margin-left:7px"><p>[TIPO] RELÁTORIO DE ROMANEIOS TOTALIZADO PARA MARCAS E PEÇAS</p></div>            
            <div style="padding: -20px;margin-left:7px; margin-top:7px"><p><b>{{date('d/m/Y')}}</b></p></div>     
            <div style="padding: -20px;margin-left:7px; margin-top:7px"><p><b>TRANSPORTE:</b> {{$descricaotransportadora or 'TODOS'}} - PERÍODO: {{date_format(date_create($dataInicial), 'd/m/Y')}} a {{date_format(date_create($dataFinal), 'd/m/Y')}}</p></div>            
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
<table style="width:100%">
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    @foreach($produtosGrupo as $item)
    <tr>
            <td>{{$item[0]->idvenda}}</td>
            <td>
                <?php $codigoDescricao = '' ; ?>
                <?php $quantidadeDescricao = '' ; ?>

                @foreach($item as $itemProduto)
                <?php $codigoDescricao .= str_pad($itemProduto->codigoreduzido, 10, " ")  ?>
                <?php $quantidadeDescricao .= str_pad(number_format($itemProduto->quantidade, 2, '.', ''), 10, " ") ; ?>
                @endforeach
               {{$codigoDescricao}}
               <br>
               {{$quantidadeDescricao}}
            </td>
            <td></td>

    </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
    </tr>
</table>
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
<table style="width:100%">
  <tr>
    <th></th>
    <th></th> 
    <th></th>
    <th></th> 
    <th></th>
  </tr>
@foreach($produtos as $item)
  <tr>
    <td>{{$item->idproduto}}</td>
    <td>{{$item->descricao}}</td>
    <td>{{$item->codigoreduzido}}</td>
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
</table><br>
<div style="padding: -20px;margin-left:7px; margin-top:7px"><p>Totalização geral de peças................................................: {{$quantidadetotalpecas}}</p></div>
<div style="padding: -20px;margin-left:7px; margin-top:7px"><p>Totalização geral de caixas...............................................: {{$quantidadetotalcaixas}}</p></div>            
@endsection 