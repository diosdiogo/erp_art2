@extends('template/updaterelatorio')

@section('content')
<center>
<table style="margin-left: 85px">
 <tr>
  <td><center><img src="{{url('assets/image/impressao/'. Auth::user()->imagem .'.jpg')}}" width="200" class="logo" alt="logo" /></center></td>
  <td><center><h1 style="margin-top: 45px"><i class="fa fa-adjust"></i> {{$empresa['nomefantasia']}}</center></h1></td>
 </tr>
</table>
<center>
    <center><div>{!!trim($empresa['descricaorelatorio'])!!}</div></center><br>
    <div><b>DATA:</b> {{date_format(date_create($datavenda), 'd/m/Y')}} <b style="margin-left:17%">ENTREGA:</b> {{date_format(date_create($dataentrega), 'd/m/Y')}} <b style="margin-left:30%">Nº:</b> {{$id}}</div>
    <hr>
        <center><h3>{!!trim($empresa['fraserelatorio'])!!}</h3></center>
    <hr>

    <table class="table-borda">
        <tbody>
        <tr>
            <td style="border-top: none;"><b>VENDEDOR:</b> {{Auth::user()->id .' - '. strtoupper(Auth::user()->name)}}</td>
        </tr>            
        <tr>
            <td style="border-top: none;"><b>CLIENTE:</b> {{$nomepessoa}}</td>
        </tr>
        <tr>
            <td><b>ENDEREÇO:</b> {{$pessoa['endereco']}} <b style="margin-left:200px">Nº</b> {{$pessoa['numero']}}</td>
        </tr>
        <tr>
            <td><b>BAIRRO:</b> {{$pessoa['bairro']}} <b style="margin-left:200px">Nº</b> {{$pessoa['telefone']}}</td>
        </tr>
        @if($pessoa['complemento'] != "")
            <tr>
                <td><b>COMPLEMENTO:</b> {{$pessoa['complemento']}}</td>
            </tr>
        @endif;
        <tr>
            <td><b>CIDADE:</b> {{strtoupper($pessoacidade)}}</td>
        </tr>                        
        <tr>
            <td><b>CPF/CNPJ:</b> {{$pessoa['cpfoucnpj']}} <b style="margin-left:100px">RG/I.E</b> {{$pessoa['rgouinscricaoestadual']}}</td>
        </tr>                        
        <tr>
            <td><b>EMAIL:</b> {{$pessoa['email']}}</td>
        </tr>                         
        <tr>
            <td style="border-bottom: none;"><b>CONDIÇÃO DE PAGAMENTO:</b> {!!$formarecebimentodescricao!!}<br> @foreach($parcelaitens as $item) {!!$item['descricao']!!} @endforeach</td>
        </tr>                                                
        </tbody>
    </table>
    <table style="margin-top:5px" class="table-produto">
        <tbody>
        <tr>
              <td><b>OBSERVAÇÃO:</b> {{$observacao}}</td>             
        </tr>
        </tbody>
    </table>
    <table style="margin-top:5px" class="table-produto">
        <tbody>
        <tr>
            <th style="width: 10px !important" align="center">QTD</th>
            <th style="width: 480px !important" align="center">Descrição</th>
            <th align="center">Uni.</th>
            <th align="center">Total</th>                        
        </tr>

        @foreach($vendaitens as $item)
        <tr>
            <td>{{$item['quantidade']}}</td>
            <td style="font-size:13px">{{$item['descricao']}}</td>
            <td>{{$item['valorunitario']}}</td>
            <td>{{$item['valortotal']}}</td>
        </tr>
        @endforeach
        @if(count($vendaitens) < 15)
            @for ($i = count($vendaitens); $i <= 15; $i++)
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td><center>-</center></td>
                </tr>
            @endfor
        @endif;
        <tr>
            <td colspan="2">
            </td>
            <td>TOTAL</td>
            <td><b>{{$valortotal}}</b></td>
        </tr>
        </tbody>
    </table>
    <br>
    <center>
<div class="footer">
<table class="table-assiantura">
 <tr>
  <td style="margin-left: -20px!important"><hr style="width: 220px"></td>
  <td><hr style="width: 220px"></td>
 </tr>
<tr>
  <td style="margin-left: -20px!important"><center>CLIENTE</center></td>

  <td><center>LOJA</center></td>
 </tr> 
</table>
<center>
</center>
@endsection