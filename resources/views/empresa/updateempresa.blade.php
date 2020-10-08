@extends('template/updatetemplate')
@section('contentInteno')

@push('script-head')
    <link href="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" />
@endpush 
    <style>        
.js .inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}

.inputfile + label {
    max-width: 80%;
    font-size: 1.25rem;
    font-weight: 700;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
    display: inline-block;
    overflow: hidden;
    padding: 0.625rem 1.25rem;
}

.no-js .inputfile + label {
    display: none;
}
.inputfile:focus + label,
.inputfile.has-focus + label {
    outline: 1px dotted #000;
    outline: -webkit-focus-ring-color auto 5px;
}
.inputfile + label svg {
    width: 1em;
    height: 1em;
    vertical-align: middle;
    fill: currentColor;
    margin-top: -0.25em;
    /* 4px */
    margin-right: 0.25em;
    /* 4px */
}
.inputfile-4 + label {
    color: #3c8dbc;
}

.inputfile-4:focus + label,
.inputfile-4.has-focus + label,
.inputfile-4 + label:hover {
    color: #224f69;
}

.inputfile-4 + label figure {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background-color: #3c8dbc;
    display: block;
    padding: 20px;
    margin: 0 auto 10px;
}

.inputfile-4:focus + label figure,
.inputfile-4.has-focus + label figure,
.inputfile-4 + label:hover figure {
    background-color: #224f69;
}

.inputfile-4 + label svg {
    width: 100%;
    height: 100%;
    fill: #f1e5e6;
}
    </style>

<div class="col-xs-12">
<div class="row">
    <div class="col-xs-1">
        {!!Form::label('label_codigo', 'Código'); !!}
        {!!Form::text('cod', $id, array('class' => 'form-control', 'disabled' => 'disabled'));!!}
    </div>
    <div class="col-xs-3">
        {!!Form::label('label_cnpj', 'CNPJ'); !!}
        {!!Form::text('cnpj', $cnpj, array('class' => 'form-control cnpj'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        {!!Form::label('label_razaosocial', 'Razão social'); !!}
        {!!Form::text('razaosocial', $razaosocial, array('class' => 'form-control', 'placeholder' => 'Digite a raz�o social'));!!}
    </div>
    <div class="col-xs-5">
        {!!Form::label('label_nomefantasia', 'Nome fantasia'); !!}
        {!!Form::text('nomefantasia', $nomefantasia, array('class' => 'form-control', 'placeholder' => 'Digite a nome fantasia'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        {!!Form::label('label_inscricaomunicipal', 'Inscrição municipal'); !!}
        {!!Form::text('inscricaomunicipal', $inscricaomunicipal, array('class' => 'form-control', 'placeholder' => 'Digite I.M'));!!}
    </div>
    <div class="col-xs-5">
        {!!Form::label('label_inscricaoestadual', 'Inscricao estadual'); !!}
        {!!Form::text('inscricaoestadual', $inscricaoestadual, array('class' => 'form-control', 'placeholder' => 'Digite a I.E'));!!}
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        {!!Form::label('Contato', 'E-mail'); !!}
        {!!Form::text('email', $email, array('class' => 'form-control', 'placeholder' => 'Digite o email'));!!}
    </div>
    <div class="col-xs-5">
        {!!Form::label('cnae', 'CNAE'); !!}
        <select id="idcnae" name="idcnae" class="form-control select2" style="width: 100%;">
            @if($cnaeDescricao)
                <option value="{{$idcnae}}">{{$cnaeDescricao}}</option>
            @endif;
        </select>                            
    </div>
</div>
<div class="row">
    <div class="col-xs-5">
        <label>CRT</label>
        <select class="form-control select2" name="idfiscalregimetributario" style="width: 100%;">
            @foreach ($regimes as $regime)
            <option value="{{$regime->id}}" {{$idfiscalregimetributario == $regime->id ? 'selected': ''}}>{{$regime->descricao}}</option>
            @endforeach
        </select>
    </div>
    <div class="col-xs-5">
        {!!Form::label('telefone', 'Telefone'); !!}
        {!!Form::text('telefone', $telefone, array('class' => 'form-control phone_with_ddd', 'placeholder' => 'Digite o telefone'));!!}
    </div>    
    <div class="col-xs-5">
        <label>Ambiente</label>
        <select class="form-control select2" name="idambiente" style="width: 100%;">
            @foreach ($ambientes as $ambiente)
                <option value="{{$ambiente->id}}" {{$idambiente == $ambiente->id ? 'selected': ''}}>{{$ambiente->descricao}}</option>
            @endforeach
        </select>
    </div>    
</div>
<div class="row mobi-row">
    <div class="col-xs-10">
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Endereco</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>
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
            </div>
        </div>
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">NF-e
              </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body">
                <div class="row"><center>
                    <div class="col-xs-12">
                        <input type="file" style="display:none" name="file-5[]" id="file-5" class="inputfile inputfile-4" data-multiple-caption="{count} files selected" multiple />
					<label for="file-5">
                        <figure>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2        2.1c-.4.3-.7 1-.6  1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"/>
                            </svg>
                        </figure> 
                        <span>SELECIONE O CERTIFICADO</span>
                    </label>
                    </div></center>
                </div>
                <div class="row">
                <div class="col-xs-12">
                    <center>
                        <div class="has-feedback">
                            <div class="col-xs-3">
                            </div>  
                            <div class="col-xs-6">
                                {!!Form::label('senha', 'Senha'); !!}
                                <input id="senha" name="senha" type="password" value="{{$senha}}" class="form-control" placeholder="Senha">
                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            </div>
                        </div>
                    </center>
                    </div>
                </div>  
                <div class="row"><br>
                    <div class="col-xs-4">
                        {!!Form::label('aliquotadosimples', 'Alíquota (Simples nacional)'); !!}
                        {!!Form::text('aliquotasimplesnacional', $aliquotasimplesnacional, array('class' => 'form-control porcentagem', 'placeholder' => 'Digite a Alíquota (Simples nacional)'));!!}
                    </div>
                        <div class="col-xs-4">
                            {!!Form::label('cfopDentro', 'CFOP padrão (Dentro do estado)'); !!}
                            <select id="idfiscalcfopdentroestado" data-placeholder="SELECIONE" name="idfiscalcfopdentroestado" class="form-control select2" style="width: 100%;">
                                @if($CFOPDentrodescricaobanco)
                                    <option value="{{$idfiscalcfopdentroestado}}">{{$CFOPDentrodescricaobanco}}</option>
                                @endif;
                            </select>
                        </div>
                        <div class="col-xs-4">
                            {!!Form::label('cfopFora', 'CFOP padrão (Fora do estado)'); !!}
                            <select id="idfiscalcfopforaestado" data-placeholder="SELECIONE" name="idfiscalcfopforaestado" class="form-control select2" style="width: 100%;">
                                @if($CFOPForadescricaobanco)
                                    <option value="{{$idfiscalcfopforaestado}}">{{$CFOPForadescricaobanco}}</option>
                                @endif;
                            </select>
                        </div>  
                </div>              
            </div>
        </div> 
        <div class="box box-solid box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Descrição no relatório
                <small style="color:#fff">parte superior</small>
              </h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button id="btnExemplo" type="button" class="btn btn-info btn-xs" data-widget="collapse">EXEMPLO
                </button>
                <button type="button" class="btn btn-default btn-sm" data-widget="collapse">
                  <i class="fa fa-minus"></i></button>
              </div>
            </div>
            <div class="box-body pad">
              <form>
                {!!Form::label('senha', 'Descrição (telefone, endereço ...)'); !!}
                <textarea name="descricaorelatorio" class="textarea" placeholder="Descrição no relatório, exemplo: EMPRESA 1, RUA SÃO JÃO AMERICO, EMPRESA 2, RUA ALBERTO JOSÉ" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">{{$descricaorelatorio}}</textarea>
                {!!Form::label('senha', 'Descrição (logo marca)'); !!}
                <input type="text" value="{{$fraserelatorio}}" name="fraserelatorio" class="form-control" placeholder="Descrição no relatório da logo marca"></input>
              </form>
            </div>
          </div>           
    </div>
</div>
<div class="modal fade" id="exemploRelatorio" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        </div>
        <div class="modal-body">
            <center><img src="{{url('assets/image/exemploRelatorio.jpg')}}" alt="Exemplo" /></center>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fechar (Esc)</button>
        </div>
    </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@push('scripts')
    <script async src="{{asset('assets/routes/js/pessoa/_cep.js') }}"></script>
    <script async src="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script src="{{asset('assets/routes/js/empresa/updateempresa.js') }}"></script>
@endpush