@extends('template/gridtemplate')

@section('content')
@include('template/gridhelper', array('botaoPersonalizado' => '<a type="button" id="btnEnviar" title="Enviar" class="btn btn-default"><i class="glyphicon glyphicon-floppy-open"></i></a>
<a type="button" id="btnImprimir" title="Imprimir DANFe" class="btn btn-default"><i class="glyphicon glyphicon-print"></i></a>
<a type="button" id="btnBaixarArquivo" title="Baixar DANFe" class="btn btn-default"><i class="glyphicon glyphicon-download-alt"></i></a>
<a type="button" id="btnEnviarEmail" title="Baixar DANFe" class="btn btn-default"><i class="glyphicon glyphicon-envelope"></i></a>
<a type="button" id="btnConsultarStatus" title="Consultar SEFAZ" class="btn btn-default"><i class="fa fa-search"></i></a>
<a type="button" id="btnCancelar" title="Cancelar" class="btn btn-default"><i class="fa fa-close"></i></a>
<a type="button" id="btnInutilizar" title="Inutilizar" class="btn btn-default"><i class="fa fa-gears"></i></a>'))

<div class="modal fade" id="notaFiscalInutilizacao" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                 <div class="col-xs-12">
                    <div class="callout callout-warning">
                            <h4><i class="icon fa fa-warning"></i> Atenção</h4>
                            <p>A inutilização só se dará caso a numeração  <strong>nunca</strong> tenha sido usada anteriormente, em notas autorizadas, denegadas ou já inutilizadas.</p>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        {!!Form::label('descricao', 'Número inicial'); !!}
                        <input required="required" type="number" class="form-control" name="numeroInicial" id="numeroInicial" autofocus></input>
                    </div>
                    <div class="col-xs-6">
                        {!!Form::label('descricao', 'Número final'); !!}
                        <input required="required" type="number" class="form-control" name="numeroFinal" id="numeroFinal"></input>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        {!!Form::label('descricao', 'Justificativa (25 - 255 caracteres)'); !!}
                        <textarea name="justificativa" required="required" id="justificativa" rows="10" cols="90"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnEnviarInutilizacao" class="btn btn-default">Enviar</button>
                <button type="button" id="btnCancelarInutilizacao" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
    <script>
        var gridnamespace = $.namespace("gridtemplatejs");

        var colunas = [{
            title: "Codigo",
            field: "id",
            width: 90,
            encoded: true
        },
        {
            title: "Número",
            field: "NUMERONF",
            width: 95,
            encoded: true
        },
        {
            title: "Pessoa",
            field: "descricaoPessoa",
            encoded: true
        },
        {
            title: "Emissão",
            field: "dataemissao",
            width: 120,
            encoded: true
        },
        {
            title: "Documento",
            field: "numerodocumentoorigem",
            width: 125,
            encoded: true
        },
        {
            title: "Situação",
            field: "situacao",
            width: 120,
            template: '<center><span class="label #=idnotafiscalsituacao == 1 ? "label-success" : (idnotafiscalsituacao == 6 ? "label-warning" : (idnotafiscalsituacao == 4 ? "label-danger" :"label-black")) #">#=situacao#</span> <i class="fa fa-file-text-o" title="#=motivoretorno#"></i> </center>',
            encoded: true
        },
        {
            title: "Valor Total",
            field: "valortotal",
            encoded: true,
            width: 120,
            template: "#= kendo.toString((valortotal * 100) / 100, 'c2') #"
        },
          gridnamespace.botaoAcao(gridnamespace.acaoEnum.SEMDELETE)];

        var colunasConfiguracao = {
                    id: {
                        type: "number"
                    },
                    descricao: {
                        type: "string"
                    },
                };

        gridnamespace.gridtemplate(colunas, colunasConfiguracao);
    </script>
    <script src="{{asset('assets/routes/js/fiscal/notafiscal/gridnotafiscal.js') }}"></script>

@endpush