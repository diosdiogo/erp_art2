@extends('template/updaterelatorio')

@section('content')

    @foreach($romaneios as $romaneio)
        @include("relatorio/venda/impressaovendafrigorificopadrao", $romaneio)
        <br><br>
    @endforeach

@endsection