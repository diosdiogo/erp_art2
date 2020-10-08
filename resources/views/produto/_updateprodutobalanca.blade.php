<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Balança</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        <label>Usa Balança? :</label> {!!Form::CheckBox('habilitabalanca', $habilitabalanca, $habilitabalanca, array('class' => 'flat-red')) !!}
                    </div>
                </div><br />
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('codigobalanca', 'Código balança'); !!}
                        {!!Form::text('codigobalanca', $codigobalanca, array('class' => 'form-control', 'placeholder' => 'Digite o código da balança', 'disabled' => 'disabled'));!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>