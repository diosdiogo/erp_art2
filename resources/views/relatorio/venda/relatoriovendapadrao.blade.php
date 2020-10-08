@extends('layouts.app')
@push('script-head')
    <link href="{{asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{asset('assets/dist/css/sweetalert.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="col-md-12">
<div class="box box-widget widget-user-2">
    <div class="widget-user-header bg-blue">
        <div class="widget-user-image">
        <img class="img-circle" src="{{url('/assets/image/impressao/relatorio_ico.png')}}" alt="User Avatar">
        </div>
        <h3 class="widget-user-username">Relatório</h3>
        <h5 class="widget-user-desc">ROMANEIOS TOTALIZADOS [SELECIONE UM TIPO]</h5>
    </div>
    <div class="box-footer">
        <div class="row" style="margin-left: 5px">
             <div class="col-xs-2" style="margin-left:-10px">
                 <input checked type="radio" name="tipo" value="1"> Peças<br>
                 <input type="radio" name="tipo" value="2"> Marcas e Peças<br>
            </div>
        </div>
        </br>
        <div class="row" style="margin-left: 5px">
            <div class="col-sm-12">
                <div class="col-xs-2" style="margin-left:-24px">
                    <label>Data inicial</label>
                    <input type="date" value="{{date('Y-m-d')}}" class="form-control" id="dataInicial" />
                </div>  
                <div class="col-xs-2" style="margin-left:-24px">
                    <label>Data final</label>        
                    <input type="date" value="{{date('Y-m-d')}}" class="form-control" id="dataFinal" />
                </div>  
                 <div class="col-xs-6"  style="margin-left:-24px">
                    {!!Form::label('ncm', 'Transportadora'); !!}
                    <select id="idtransportadora" name="idtransportadora" class="form-control select2" style="width: 100%;">
                    </select>
                </div>               
                <div class="col-xs-2"  style="margin-left:-24px">
                    <button style="margin-top: 24px" class="btn btn-primary" id="btnGerar"><i class="fa fa-search"> </i></button>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

</div>
</div>
@endsection

@push('scripts')
	    <script src="{{asset('assets/dist/js/updatetemplateall.js') }}"></script>
        <script src="{{asset('assets/dist/js/updatetemplate.js') }}"></script>
        <script>
            $.namespace("relatoriopadrao", function(){
                var publico = {};
                
                var validarGerarRelatorioOnClick = function(){
                    var url = "/relatoriovenda/validargerarrelatorio";
                    var parametros = {
                        dataInicial : $("#dataInicial").val(),
                        dataFinal : $("#dataFinal").val(),
                        idtransportadora : $("#idtransportadora").val()
                    };

                    $.get(url, parametros, function(data){
                          console.log(data);          
                          if(data == 0){
                            swal("BUSCA SEM DADOAS, ALTERE O FILTRO");
                          }else{
                            gerarOnClick();
                          }

                    });
                    
                }
                
                var gerarOnClick = function(){
                    var url = "/relatoriovenda/imprimir/" + "?dataInicial=" + $("#dataInicial").val() + "&dataFinal=" + $("#dataFinal").val() + "&idtransportadora=" + $("#idtransportadora").val()
                    +"&tipo=" + $("input:checked" ).val();
                    window.open(url, "_blank");
                }
                
                publico.init = function(){
                    setTimeout(function(){
                        updatetemplatejs.comboBoxSelect("idtransportadora", "/relatoriovenda/obtertransportadora");
                    }, 500);

                    $("#btnGerar").on("click", validarGerarRelatorioOnClick);
                }

                return publico;
            });

            $.namespace("relatoriopadrao").init();
        </script>
@endpush