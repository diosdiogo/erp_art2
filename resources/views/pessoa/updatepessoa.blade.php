@extends('template/updatetemplate')

@section('contentInteno')
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
    <div class="col-xs-2" style="margin-top: 30px">
        <label>
            Ativo: {!!Form::CheckBox('ativo', true, $ativo, array('class' => 'flat-red')) !!}
        </label>
    </div>
   {{-- <div class="col-sm-2">
        {!!Form::label('at_create', 'Data de cadastro'); !!}
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>

            {!!Form::text('at_create', $at_create, array('class' => 'form-control datepicker', 'disabled' => 'disabled'));!!}
        </div>
	</div>
    <div class="col-xs-2">
        {!!Form::label('at_update', 'Última alteração'); !!}
        <div class="input-group date">
            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
            {!!Form::text('at_update', $at_update, array('class' => 'form-control datepicker', 'disabled' => 'disabled'));!!}
        </div>
    </div> --}}
</div>
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('codigo', 'Código próprio'); !!}
        {!!Form::text('codigopesonalizado', $codigopesonalizado, array('class' => 'form-control'));!!}
    </div>
    <div class="col-xs-4">
        {!!Form::label('tipopessoa', 'Tipo de pessoa'); !!}
        <select id="idpessoatipo" name="idpessoatipo" {{$id > 0 ? 'disabled="disabled"' : ''  }} class="form-control select2" style="width: 100%;">
            @foreach ($pessoaTipos as $pessoaTipo)
                @if($idpessoatipo == $pessoaTipo->id)
                    <option value="{{$pessoaTipo->id}}" selected>{{	$pessoaTipo->descricao}}</option>
                @else
                    <option value="{{$pessoaTipo->id}}">{{	$pessoaTipo->descricao}}</option>
                @endif
            @endforeach
		</select>
    </div>
    <div class="col-xs-5">
        {!!Form::label('razaoSocial', 'Razão social'); !!}
        {!!Form::text('razaosocial', $razaosocial, array('class' => 'form-control', 'placeholder' => 'Digite a razão social'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
            {!!Form::label('nomeFantasia', 'Nome fantasia'); !!}
            {!!Form::text('nomefantasia', $nomefantasia, array('class' => 'form-control', 'placeholder' => 'Digite a nome fantasia'));!!}
    </div>
    <div class="col-xs-5">
        <label>Relações</label>
        <select class="form-control select2" name="relacao[]" id="relacao" multiple="multiple" data-placeholder="Selecione" style="width: 100%;">
            @foreach ($pessoaRelacoes as $pessoaRelacao)
                <option value="{{$pessoaRelacao->id}}" {{in_array($pessoaRelacao->id, $relacao) ? 'selected' : ''}}>{{$pessoaRelacao->descricao}}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="row">
</div>
<div class="row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary" id="idBoxBasico" style="margin-top:10px">
            <div class="box-header with-border">
                <h3 class="box-title">Dados Basicos</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-3">
                        {!!Form::label('cpfoucnpj', 'CPF ou CNPJ'); !!}
                        {!!Form::text('cpfoucnpj', $cpfoucnpj, array('class' => 'form-control', 'placeholder' => 'Digite o CPF ou CNPJ'));!!}
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('tipocontribuinte', 'Tipo Contribuinte'); !!}
                        <select class="form-control select2" id="idpessoatipocontribuinte" name="idpessoatipocontribuinte" style="width: 100%;">
                            @foreach ($pessoaTipoContribuintes as $pessoaTipoContribuinte)
                            <option value="{{$pessoaTipoContribuinte->id}}" {{$idpessoatipocontribuinte == $pessoaTipoContribuinte->id ? 'selected' : ''}}>{{	$pessoaTipoContribuinte->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-2">
                        {!!Form::label('ufs', 'UF RG/IE'); !!}
                        <select class="form-control select2" name="idufdocumento" style="width: 100%;">
                            <option value="">[...]</option>
                            @foreach ($UFs as $uf)
                            <option value="{{$uf->id}}" {{$idufdocumento == $uf->id ? 'selected' : ''}}>{{	$uf->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-2">
                        {!!Form::label('inscricaoEstadual', 'RG/Inscrição Estadual'); !!}
                        {!!Form::text('rgouinscricaoestadual', $rgouinscricaoestadual, array('class' => 'form-control', 'placeholder' => 'Digite ou RG/inscrição estadual'));!!}
                    </div>
                    <div class="col-xs-2">
                        {!!Form::label('orgaoRG', 'RG órgão emissor'); !!}
                        {!!Form::text('rgorgaoemissor', $rgorgaoemissor, array('class' => 'form-control', 'placeholder' => 'Digite o órgão'));!!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-2">
                        <label>Sexo</label>
                        <select name="idpessoasexo" id="idpessoasexo" class="form-control select2" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            @foreach ($pessoasexos as $pessoasexo)
                            <option value="{{$pessoasexo->id}}" {{$idpessoasexo == $pessoasexo->id ? 'selected' : ''}}>{{$pessoasexo->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-3">
                        {!!Form::label('Contato', 'Nome contato'); !!}
                        {!!Form::text('nomecontato', $nomecontato, array('class' => 'form-control', 'placeholder' => 'Digite o nome do contato'));!!}
                    </div>
                    <div class="col-xs-7">
                        {!!Form::label('Contato', 'E-mail'); !!}
                        {!!Form::text('email', $email, array('class' => 'form-control', 'placeholder' => 'Digite o email'));!!}
                    </div>
                    <div class="col-sm-2" style="display:none">
                        {!!Form::label('at_create', 'Nascimento/Abertura'); !!}
                        <div class="input-group date">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>

                            {!!Form::text('datanascimentoouabertura', $datanascimentoouabertura, array('class' => 'form-control datepicker'));!!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-9">
                        {!!Form::label('site', 'Site'); !!}
                        <div class="input-group">
                            {!!Form::text('site', $site, array('class' => 'form-control', 'placeholder' => 'Digite o site'));!!}
                            <span id="btnSite" class="btn btn-default input-group-addon"><i style="color:dodgerblue" class="fa fa-chrome"></i></span>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <label>Ramo de atividade</label>
                        <select name="idpessoaramoatividade" id="idpessoaramoatividade" class="form-control select2" style="width: 100%;">
                            <option value="">SELECIONE</option>
                            @foreach ($pessoaramoatividades as $pessoaramoatividade)
                            <option value="{{$pessoaramoatividade->id}}" {{$idpessoaramoatividade == $pessoaramoatividade->id ? 'selected' : ''}}>{{$pessoaramoatividade->descricao}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        {!!Form::label('telefone', 'Telefone'); !!}
                        {!!Form::text('telefone', $telefone, array('class' => 'form-control phone_with_ddd', 'placeholder' => 'Digite o telefone'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('celular', 'Celular'); !!}
                        {!!Form::text('celular', $celular, array('class' => 'form-control cell_with_ddd', 'placeholder' => 'Digite o celular'));!!}
                    </div>
                    <div class="col-xs-4">
                        {!!Form::label('Fax', 'Fax'); !!}
                        {!!Form::text('fax', $fax, array('class' => 'form-control phone_with_ddd', 'placeholder' => 'Digite o fax'));!!}
                    </div>
                </div>
                <div class="col-xs-12 mobi-row">
                    <div class="row">
                        <div id="accordion">
                            <div class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" class="collapsed">
                                            Endereço
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in" aria-expanded="false" style="height: 0px;">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                {!!Form::label('cep', 'CEP'); !!}
                                                {!!Form::text('cep', $cep, array('class' => 'form-control cep', 'placeholder' => 'Digite o cep'));!!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!!Form::label('logradouro', 'Endereço (Logradouro)'); !!}
                                                {!!Form::text('endereco', $endereco, array('class' => 'form-control', 'placeholder' => 'Digite o endereço'));!!}
                                            </div>
                                            <div class="col-xs-2">
                                                {!!Form::label('numero', 'Numero'); !!}
                                                {!!Form::text('numero', $numero, array('class' => 'form-control', 'placeholder' => 'Digite o numero'));!!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!!Form::label('Complemento', 'Complemento'); !!}
                                                {!!Form::text('complemento', $complemento, array('class' => 'form-control', 'placeholder' => 'Digite o complemento'));!!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-4">
                                                {!!Form::label('bairro', 'Bairro'); !!}
                                                {!!Form::text('bairro', $bairro, array('class' => 'form-control', 'placeholder' => 'Digite o bairro'));!!}
                                            </div>
                                            <div class="col-xs-4">
                                                {!!Form::label('cidade', 'Cidade'); !!}
                                                <select id="idcidade" name="idcidade" class="form-control select2" style="width: 100%;">
                                                    @if($cidadeDescricao)
                                                        <option value="{{$idcidade}}">{{$cidadeDescricao}}</option>
                                                    @endif;
                                                </select>                            
                                            </div>
                                            <div class="col-xs-4">
                                                {!!Form::label('pontoreferencia', 'Ponto de referência'); !!}
                                                {!!Form::text('pontoreferencia', $pontoreferencia, array('class' => 'form-control', 'placeholder' => 'Digite o ponto de referência'));!!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-2">
                                                {!!Form::label('ufs', 'UF'); !!}
                                                <select class="form-control select2" name="iduf" style="width: 100%;">
                                                    <option value="">[...]</option>
                                                    @foreach ($UFs as $uf)
                                                    <option value="{{$uf->id}}" {{$iduf == $uf->id ? 'selected' : ''}}>{{	$uf->descricao}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                                <div class="col-xs-5">
                                                    <label>Tipo</label>
                                                    <select class="form-control select2" name="idenderecotipo" style="width: 100%;">
                                                        @foreach ($enderecotipos as $enderecotipo)
                                                        <option value="{{$enderecotipo->id}}" {{$idenderecotipo == $enderecotipo->id ? 'selected': ''}}>{{$enderecotipo->descricao}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <div class="box box-solid box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Gerência</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <label>
                                    Ignora checagem de limite de crédito: {!!Form::CheckBox('ignoralimitecredito', true, $ignoralimitecredito, array('class' => 'flat-red')) !!}
                                </label>
                            </div>
                        </div><br />
                        <div class="row">
                            <div class="col-xs-4">
                                {!!Form::label('limiteDeCredito', 'Limite de crédito'); !!}
                                {!!Form::text('limitecredito', $limitecredito, array('class' => 'form-control money', 'placeholder' => 'Digite o limite de crédito', 'maxlength' => '10'));!!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <label>Fechamento (Cobrança)</label>
                                <select class="form-control select2" name="iddiadasemana" style="width: 100%;">
                                    @foreach ($diasdasemana as $diadasemana)
                                    <option value="{{$diadasemana->id}}" {{$iddiadasemana == $diadasemana->id ? 'selected': ''}}>{{htmlentities($diadasemana->descricao, ENT_QUOTES, "UTF-8")}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                {!!Form::label('observacao', 'Observação'); !!}
                                {!!Form::textArea('observacao', $observacao, array('class' => 'form-control'));!!}<br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- AQUI É ULTIMO DIV -->

@endsection
@push('scripts')
    <script src="{{asset('assets/routes/js/pessoa/updatepessoa.js') }}"></script>
    <script src="{{asset('assets/routes/js/pessoa/_cep.js') }}"></script>
@endpush