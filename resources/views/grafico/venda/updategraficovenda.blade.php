@extends('layouts.app')
@push('script-head')
    <link href="{{url('/assets/plugins/morris/morris.css') }}" rel="stylesheet">
@endpush
@section('content')
   <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
        <div class="col-md-6">
          <!-- AREA CHART -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">VENDAS DO ANO DE {{date("Y")}}</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                    <div class="chart" id="chart-vendaAnual" style="height: 300px;"></div>
              </div>
            </div>
          </div>
            <!-- /.box-body -->
          <!-- /.box -->
     
      </div>
      <div class="col-md-6">
          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">5 PRODUTOS MAIS VENDIDOS</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
                <div class="chart" id="sales-chart" style="height: 300px; position: relative;"></div>
            </div>
          </div>
        </div>
        </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="{{asset('assets/plugins/morris/morris.min.js') }}"></script>
<script>    
    $(function () {
        var arr = JSON.parse('{{$parametroExtra["graficoProdutoQuantidade"]}}'.replaceAll('&quot;', '"'));//.replace('[', '').replace(']', '');
        var PieData = [];
        for (var i = 0; i < arr.length; i++){
            var obj = arr[i];
            for (var key in obj){
                var attrName = key;
                var attrValue = obj[key];
                
                PieData.push({
                    y: attrValue,
                    a: attrName
                });
            }
        }

         var bar = new Morris.Bar({
            element: 'sales-chart',
            resize: true,
            data:PieData,
            barColors: ['#3c8dbc'],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['QUANTIDADE'],
            hideHover: 'auto'
        });

        var months = ['JAN', 'FEV', 'MAR', 'ABR', 'MAI', 'JUN', 'JUL', 'AGO', 'SET', 'OUT', 'NOV', 'DEZ'];
        var i = -1;
        var graficoVendaAnual = JSON.parse('{{$parametroExtra["graficoVendaAnual"]}}'.replaceAll('&quot;', '"'));
        var areaData = [];
        $.each( graficoVendaAnual, function( key, value ) {
            areaData.push({
                descricao: value.mes,
                item1: value.valortotal
            });
        });


        var area = new Morris.Area({
        element: 'chart-vendaAnual',
        resize: true,
        data: areaData,
        xkey: 'descricao',
        ykeys: ['item1'],
        xLabelFormat: function (x) {
            i++;
            return months[i];
        },
        yLabelFormat: function (x) {
            return "R$ " + x.format();
        },        
        labels: ['VALOR'],
        lineColors: ['#a0d0e0'],
        hideHover: 'auto'
        });
  })
</script>
@endpush
