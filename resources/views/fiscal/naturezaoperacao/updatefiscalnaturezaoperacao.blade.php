@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
    <div class="col-xs-3" style="margin-top: 30px">
        <label>
            Ativo: {!!Form::CheckBox('ativo', $ativo, $ativo, array('class' => 'flat-red')) !!}
        </label>
    </div>
    <div class="col-xs-3">
        {!!Form::label('tipopessoa', 'Tipo de operação'); !!}
        <select id="idfinanceiromovimentotipo" name="idfinanceiromovimentotipo" class="form-control select2" style="width: 100%;">
            <option value="">SELECIONE</option>
            @foreach ($financeiromovimentostipo as $financeiromovimentotipo)
                <option value="{{$financeiromovimentotipo->id}}" {{$idfinanceiromovimentotipo == $financeiromovimentotipo->id ? 'selected': ''}}>{{$financeiromovimentotipo->descricao}}</option>
            @endforeach
		</select>
    </div>
    <div class="col-xs-3">
        {!!Form::label('finalidade', 'Finalidade'); !!}
        <select id="idnaturezaoperacaofinalidade" name="idnaturezaoperacaofinalidade" class="form-control select2" style="width: 100%;">
            @foreach ($naturezaoperacaofinalidade as $finalidade)
                <option value="{{$finalidade->id}}" {{$idnaturezaoperacaofinalidade == $finalidade->id ? 'selected' : ''}}>{{$finalidade->descricao}}</option>
            @endforeach
        </select>
    </div>     
</div>
<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Dados Basicos</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                    <div class="row">
                        <div class="col-xs-12">
                                {!!Form::label('descricao', 'Descrição'); !!}
                                {!!Form::text('descricao', $descricao, array('class' => 'form-control', 'placeholder' => 'Digite a descrição'));!!}
                            </div>
                        </div>
                    <div class="row">
                        <div class="col-xs-6">
                            {!!Form::label('ncm', 'CFOP Dentro do estado'); !!}
                            <select id="idfiscalCFOPDentroEstado" data-placeholder="SELECIONE" name="idfiscalCFOPDentroEstado" class="form-control select2" style="width: 100%;">
                                @if($CFOPDentrodescricaobanco)
                                    <option value="{{$idfiscalCFOPDentroEstado}}">{{$CFOPDentrodescricaobanco}}</option>
                                @endif;
                            </select>
                        </div>
                        <div class="col-xs-6">
                            {!!Form::label('ncm', 'CFOP Fora do estado'); !!}
                            <select id="idfiscalCFOPForaEstado" data-placeholder="SELECIONE" name="idfiscalCFOPForaEstado" class="form-control select2" style="width: 100%;">
                                @if($CFOPForadescricaobanco)
                                    <option value="{{$idfiscalCFOPForaEstado}}">{{$CFOPForadescricaobanco}}</option>
                                @endif;
                            </select>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{asset('assets/routes/js/fiscal/naturezaoperacao/updatefiscalnaturezaoperacao.js') }}"></script>
@endpush