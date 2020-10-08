@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Dados Basicos</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-9" style="margin-top: 30px">
                        <label>
                            Permite venda com estoque negativo: {!!Form::CheckBox('permitevendacomestoquenegativo', $permitevendacomestoquenegativo, $permitevendacomestoquenegativo, array('class' => 'flat-red')) !!}
                        </label>
                    </div>
                    <div class="col-xs-9" style="margin-top: 30px">
                        <label>
                            Usa detalhes no cadastro: {!!Form::CheckBox('usadetalhe', $usadetalhe, $usadetalhe, array('class' => 'flat-red')) !!}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
