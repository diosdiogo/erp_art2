
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
    <div style="padding: -20px;margin-left:7px"><p><b>ROMANEIO      -      Nº </b>{{str_pad($id, 6, "0", STR_PAD_LEFT)}}</p></div>
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
    <div style="padding: -20px; margin-bottom:7px;margin-left:7px"><p><b>CLIENTE        :</b> {{$nomepessoa}}</p></div>        
    <div style="padding: -20px;margin-left:7px"><p><b>EMISSAO        :</b> {{date_format(date_create($datavenda), 'd/m/Y')}}   -   <strong>VENCIMENTO: </strong> {{$datavencimento}}</p></div> 
    <div style="padding: -20px; margin-top:5px ; margin-bottom:7px;margin-left:7px">
    <p>
        <b>OBS                  : </b>{{$observacao}}
    </p>
</div>        
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
    <center><div style="padding: -20px;margin-left:7px"><p><b>** PRODUTOS **</b></p></div></center><br>
<table style="margin-left: -12px">
    <tbody>
    <tr>
        <th style="width: 250px !important" align="left">DESCRICAO</th>
        <th style="width: 80px !important" align="left">PC/CX</th>
        <th align="left">PESO TOTAL</th>            
        <th style="width: 100px !important" align="left">UNITARIO</th>
        <th style="width: 120px !important" align="left">TOTAL</th>                       
    </tr>

    @foreach($vendaitens as $item)
        <tr>
            <td style="font-size:13px">{{$item['idproduto'] .' '.  $item['descricao']}}</td>
            <td>{{$item['quantidadepeca']}}P</td>
            <td>[______________]</td>            
            <td>{{$item['valorunitario']}}</td>
            <td>[_____________________]</td>
        </tr>
        <tr>
            <td colspan="5">{!!$item['quantidadequadradodescricao']!!}</td>
        </tr>
             
    @endforeach
    </tbody>
</table>
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>    
    <div style="padding: -20px;margin-left:7px"><p><b>TRANSPORTE: ** {{$descricaotransportadora}} **</b> <b style="margin-left:9%">TOTAL</b> : [______________________]</p></div>
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>
        <div style="padding: -20px;margin-left:7px"><p><b>OBSERVAÇÃO: </b> {{$observacao}}</p></div>
<center>---------------------------------------------------------------------------------------------------------------------------------------------</center>    
    <div style="padding: -20px;margin-left:7px"><p><b>ASSINATURA:___________________________________________ DATA: _____/_____/_____</b></p></div>    
