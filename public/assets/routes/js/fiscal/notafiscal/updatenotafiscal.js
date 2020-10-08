 $.namespace("updatenotafiscal", function(){
    var publico = {};
    var gridItemElemento = $('#griditem');
    var notaFiscalItemModel = $("#itemNotaFiscalModal");
    var alterar = false;

    var visualizarDanfeOnClick = function(){
        var url = "/notafiscal/visualizardanfe";
        window.open('/notafiscal/visualizardanfe');
    }

    var inicializarEvento = function(){
        $("#btnVisualizarDanfe").on("click", visualizarDanfeOnClick);
        inicializarEventoPessoa();
        setTimeout(function(){
            obterPessoaEndereco();
        }, 350);
    }

    var inicializarEventoPessoa = function(){
        $("#idpessoa").on("select2:select", obterPessoaEndereco);
        notaFiscalItemModel.on('shown.bs.modal', modelShow);
        shortcut.add("F1", atalhoParaInserirItem);
    }

    
    var atalhoParaInserirItem = function (e) {
        e.preventDefault();
        $("#inserirItemNotaFiscal").trigger("click");
    }

    var modelShow = function () {
        alterar = true;
        if(!alterar){
            var box = $("#boxLancamento");
            box.startLoad()
            box.removeLoad();
            var url = "/notafiscal/inserirnotafiscalitem";
            $.get(url, function(data){
                notaFiscalItemModel.find(".modal-body").html(data);
            });
        }
    }

    var obterPessoaEndereco = function(data){
        var idPessoa = data != null ? data.params.data.id : $("#idpessoa").val();
        if(idPessoa != null && idPessoa > 0){
            var url = "/notafiscal/obterpessoaendereco";
            var parametro = {id : idPessoa};

            $.get(url, parametro, function(data){
                var dados = data[0];
                $("#cep").val(dados.cep);
                $("#bairro").val(dados.bairro);
                $("input[name='endereco']").val(dados.endereco);
                $("input[name='numero']").val(dados.numero);
                $("input[name='complemento']").val(dados.complemento);
                $("#idcidade").val(dados.idcidade);
                $("#idcidade").select2("trigger", "select", {
                    data: {id: dados.idcidade, text: dados.cidadeDescricao}
                });
                $("input[name='pontoreferencia']").val(dados.pontoreferencia);
                $("#enderecotipo").val(dados.idenderecotipo).change();
                $("#uf").val(dados.iduf).change();
            });
        }
    }

    publico.init = function () {
        $.minimizarEBloquearMenuLateral();
        updatetemplatejs.comboBoxSelect("idnaturezaoperacao", "/notafiscal/obternaturezaoperacao");
        updatetemplatejs.comboBoxSelect("idpessoa", "/notafiscal/obterpessoa");   
        updatetemplatejs.comboBoxSelect("idcidade", "/pessoa/obtercidade");
     
        inicializarEvento();
    };

    gridItemElemento.DataTable( {
        "bFilter": false,
        "paging": true,
        "info": true,
        "pagingType": "full_numbers",
          "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
    },
        "ajax": {
            "url": "/notafiscal/obteritens",
            "dataSrc": ""
        },
        "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": ""
        } ],
        "columns": [
            { "data": "item" },
            { "data": "descricao" },
            { "data": "unidademedidacomercial" },            
            { "data": "quantidade" },
            {
                data: "valorunitario",
                sortable: false,
                render: function ( data, type, full, meta ) {
                    return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                }
            },
            {
                data: "valordesconto",
                sortable: false,
                render: function ( data, type, full, meta ) {
                    return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                }
            },
            { "data": "CST" },
            { "data": "CFOP" },
            {
                data: "valortotalitem",
                sortable: false,
                render: function ( data, type, full, meta ) {
                    return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                }
            },
            {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                    var buttonID = "withdraw_"+full.id;
                    return '<a class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>' // <a class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>;
                }
            },
        ]
    } );

    return publico;
});

$(function(){
    $.namespace("gridnotafiscal").inicializarEventosCompartilhados();
    $.namespace("updatenotafiscal").init();
});