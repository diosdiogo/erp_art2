@extends('template/updatetemplate')
@section('contentInteno')
<div class="row">
    <div class="col-xs-12">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Produto</a></li>
              <li><a href="#tab_2" data-toggle="tab">Dados Fiscais</a></li>
              <li><a href="#tab_3" data-toggle="tab">Balança</a></li>      
              <li><a href="#tab_4" data-toggle="tab">Detalhes</a></li>                            
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                  @include("produto/_updateproduto")
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                  @include("produto/_updateprodutodadosfiscais")
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                  @include("produto/_updateprodutobalanca")
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_4">
                  @include("produto/_updateprodutodetalhes")
              </div>
              <!-- /.tab-pane -->              
            </div>
            <!-- /.tab-content --> 
          </div>        
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{asset('assets/routes/js/produto/updateproduto.js') }}"></script>
    <script>
        $("#btnInserirEstoque").on("click", function(e){
            e.preventDefault();
        });
    </script>
@endpush