<div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px;">
            <div class="box-header with-border">
                <h3 class="box-title">Fiscal</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-4">
                        <label>Tipo</label>
                        <select class="form-control select2" name="idprodutofiscaltipo" data-placeholder="Selecione" style="width: 100%;">
                            @foreach ($fiscalTipos as $tipo)
                                <option value="">SELECIONE</option>
                                <option value="{{$tipo->id}}" {{$idprodutofiscaltipo == $tipo->id ? 'selected': ''}}>{{$tipo->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('ncm', 'NCM'); !!}
                        <select id="idfiscalncm" name="idfiscalncm" class="form-control select2" style="width: 100%;">
                            @if($ncmdescricaobanco)
                                <option value="{{$idfiscalncm}}">{{$ncmdescricaobanco}}</option>
                            @endif;
                        </select>
                    </div>
                    <div class="col-xs-4">
                        <label>Origem da mercadoria</label>
                        <select class="form-control select2" name="idorigemmercadoria" data-placeholder="Selecione" style="width: 100%;">
                            @foreach ($fiscalorigensmercadoria as $origemmercadoria)
                                <option value="">SELECIONE</option>
                                <option value="{{$origemmercadoria->id}}" {{$idorigemmercadoria == $origemmercadoria->id ? 'selected': ''}}>{{$origemmercadoria->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('cest', 'Código Especificador da Substituição Tributária'); !!}
                        <select id="idfiscalcest" name="idfiscalcest" class="form-control select2" style="width: 100%;">
                            @if($cestdescricaobanco)
                            <option value="{{$idfiscalcest}}">{{$cestdescricaobanco}}</option>
                            @endif;
                        </select>
                    </div>
                    <div class="col-xs-6">
                        {!!Form::label('cest', 'CFOP'); !!}
                        <select id="idcfop" name="idcfop" class="form-control select2" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            @foreach ($fiscalcfop as $cfop)
                                <option value="{{$cfop->id}}" {{$idcfop == $cfop->id ? 'selected': ''}}>{{$cfop->descricao}}</option>
                            @endforeach
                        </select>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div> <!-- AQUI É ULTIMO DIV -->
{{-- <div class="row">
    <div class="col-xs-12">
        <div class="box box-solid box-primary" style="margin-top:10px;">
            <div class="box-header with-border">
                <h3 class="box-title">Imposto padrão (Alíquota %)</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</div> <!-- AQUI É ULTIMO DIV --> --}}


<div class="row">
    <div class="col-xs-12">
         <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_fiscal_1" data-toggle="tab">ICMS</a></li>
              <li><a href="#tab_fiscal_2" data-toggle="tab">PIS</a></li>
              <li><a href="#tab_fiscal_3" data-toggle="tab">CONFINS</a></li>      
              <li><a href="#tab_fiscal_4" data-toggle="tab">IPI</a></li>                            
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_fiscal_1">
                   <div class="row">
                        <div class="col-xs-6">
                            {!!Form::label('cst', 'CST ou CSOSN'); !!}
                            <select id="idcsticms" name="idcsticms" class="form-control select2" style="width: 100%;">
                                <option value="">SELECIONE</option>
                                @foreach ($fiscalcsticms as $cst)
                                    <option value="{{$cst->id}}" {{$idcsticms == $cst->id ? 'selected': ''}}>{{$cst->descricao}}</option>
                                @endforeach
                            </select>
                        </div> 
                        <div class="col-xs-3">
                            {!!Form::label('aliq', 'Alíquota %'); !!}
                            {!!Form::text('icms', $icms, array('class' => 'form-control money', 'placeholder' => 'Digite a Alíquota %'));!!}
                        </div>                        
                   </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_fiscal_2">
                 <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('CST', 'CST'); !!}
                        <select class="form-control select2" id="idcstpis" {{($desabilitarSimplesNacional ? "disabled" : "" )}} name="idcstpis" data-placeholder="SELECIONE" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            @foreach ($fiscalcestpiscofins as $cst)
                                <option value="{{$cst->id}}" {{$idcstpis == $cst->id ? 'selected': ''}}>{{$cst->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('aliq', 'Alíquota %'); !!}
                        {!!Form::text('pis', $pis, array('class' => 'form-control money', 'placeholder' => 'Digite a Alíquota %', ($desabilitarSimplesNacional ? "disabled" : "" )));!!}
                    </div>                     
                  </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_fiscal_3">
                 <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('CST', 'CST'); !!}
                        <select class="form-control select2" {{($desabilitarSimplesNacional ? "disabled" : "" )}} id="idcstcofins" name="idcstcofins" data-placeholder="SELECIONE" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            @foreach ($fiscalcestpiscofins as $cst)
                                <option value="{{$cst->id}}" {{$idcstcofins == $cst->id ? 'selected': ''}}>{{$cst->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('aliq', 'Alíquota %'); !!}
                        {!!Form::text('cofins', $cofins, array('class' => 'form-control money', 'placeholder' => 'Digite a Alíquota %', ($desabilitarSimplesNacional ? "disabled" : "" )));!!}
                    </div>                     
                  </div>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_fiscal_4">
                 <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('CST', 'CST'); !!}
                        <select class="form-control select2" {{($desabilitarSimplesNacional ? "disabled" : "" )}} id="idcstipi" name="idcstipi" data-placeholder="SELECIONE" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            @foreach ($fiscalcestipi as $cst)
                                <option value="{{$cst->id}}" {{$idcstipi == $cst->id ? 'selected': ''}}>{{$cst->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                        <div class="col-xs-3">
                            {!!Form::label('aliq', 'Alíquota %'); !!}
                            {!!Form::text('ipi', $ipi, array('class' => 'form-control money', 'placeholder' => 'Digite a Alíquota %', ($desabilitarSimplesNacional ? "disabled" : "" )));!!}
                        </div> 
                  </div>                  
              </div>
              <!-- /.tab-pane -->              
            </div>
            <!-- /.tab-content --> 
          </div>        
    </div>
</div>