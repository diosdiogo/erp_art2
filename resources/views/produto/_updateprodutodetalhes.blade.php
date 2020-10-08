    <div class="row">
        <div class="col-xs-10">
            <div class="box box-solid box-primary" style="margin-top:10px">
                <div class="box-header with-border">
                    <h3 class="box-title">Detalhes</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-xs-6">
                            {!!Form::label('peso', 'Peso'); !!}
                            {!!Form::text('peso', $peso, array('class' => 'form-control money', 'placeholder' => 'Digite o peso'));!!}
                        </div>
                        <div class="col-xs-6">
                            {!!Form::label('largura', 'Largura'); !!}
                            {!!Form::text('largura', $largura, array('class' => 'form-control money', 'placeholder' => 'Digite a largura'));!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            {!!Form::label('altura', 'Altura'); !!}
                            {!!Form::text('altura', $altura, array('class' => 'form-control money', 'placeholder' => 'Digite a altura'));!!}
                        </div>
                        <div class="col-xs-6">
                            {!!Form::label('comprimento', 'Comprimento'); !!}
                            {!!Form::text('comprimento', $comprimento, array('class' => 'form-control money', 'placeholder' => 'Digite o comprimento'));!!}
                        </div>
                    </div>        
                    <div class="row">
                        <div class="col-xs-12">
                            {!!Form::label('descricao', 'Observação'); !!}
                            {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}
                        </div
                    </div>                                        
                </div>
            </div>
        </div>
    </div>
</div>