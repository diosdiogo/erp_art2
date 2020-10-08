$.namespace("gridtemplatejs", function(){
    var publico = {};
    var btnPesquisar = $("#btnPesquisar");

    var atualizar = function(){
        location.reload();
    }

    publico.acaoEnum ={
        ALTERAR : 1,
        VISUALIZAR : 2,
        DELETAR : 3,
        TODAS : 4,
        SEMDELETE : 5,
    };

    var acaoEnumTodosEAcaoParametro = function(parametro, acao){
        var acaoEnum = publico.acaoEnum;
        return acaoEnum.TODAS == acao || acaoEnum.SEMDELETE || parametro == acao;
    }

    publico.botaoAcao = function(acao, templateAdicional){
        var width = "120px";
        var template = "";
        var acaoEnum = publico.acaoEnum;

        if(acaoEnumTodosEAcaoParametro(acaoEnum.ALTERAR, acao))
            template += "<a class='btn btn-xs btn-warning' href='' style='min-width:16px;'><span class='fa fa-edit'></span></a> ";

        if(acaoEnumTodosEAcaoParametro(acaoEnum.VISUALIZAR, acao))
            template += "<a class='btn btn-xs btn-default' href='' style='min-width:16px;'><span class='fa fa-eye'></span></a> ";

        if(acao != acaoEnum.SEMDELETE && acaoEnumTodosEAcaoParametro(acaoEnum.DELETAR, acao))
            template += "<a class='btn btn-xs btn-danger' href='' style='min-width:16px;'><span class='fa fa-trash-o'></span></a>";

        if(templateAdicional != undefined)
            template += templateAdicional;

        width = obterTamanhoParaColunaAcao(acao);

        return {
            command: [
                {
                    id: "edit",
                    name: "edit",
                    template: template
                }
            ],
            title: " ",
            width: width
        };
    }

    var obterTamanhoParaColunaAcao = function(acao){
        var acaoEnum = publico.acaoEnum;
        
        switch (acao) {
            case acaoEnum.ALTERAR:
            case acaoEnum.VISUALIZAR:
            case acaoEnum.DELETAR:
                return "50px";       
            case acaoEnum.SEMDELETE:
                return "80px";
            case acaoEnum.TODAS:
                return "120px";
        }
    }

    /* DEPRECAT- (usar botaoAcao)*/
    publico.botaoVisualizar = function (apenasVisualizar) {
        console.warn("Calling deprecated function!"); 

        var width = "120px";
        var template = "";
        
        if (!apenasVisualizar)
            template += "<a class='btn btn-xs btn-warning' href='' style='min-width:16px;'><span class='fa fa-edit'></span></a> ";

        template += "<a class='btn btn-xs btn-default' href='' style='min-width:16px;'><span class='fa fa-eye'></span></a> ";

        if (!apenasVisualizar)
            template += "<a class='btn btn-xs btn-danger' href='' style='min-width:16px;'><span class='fa fa-trash-o'></span></a>";

        if (apenasVisualizar)
            width = "50px";

        return {
            command: [
                {
                    id: "edit",
                    name: "edit",
                    template: template
                }
            ],
            title: " ",
            width: width
        };
    }

    var inicializarAtalho = function () {
        shortcut.add("F1", function () {
            var url = $("#btnInserir").attr('href');
            if(url)
                location.href = url;
        });

        shortcut.add("Enter", function () {
            btnPesquisar.trigger("click");
        });
    }

    var obterUrlParaAcao = function () {
        return "/" + (document.URL).split("/")[3];
    }

    var acaoAlterarDeletar = function () {
        $("#gridtemplate").on("dblclick", "tr", function (item) {
            if($("span.fa.fa-edit").length > 0)
                alterarItem();
            else
                visualizarItem();
        });
    }

     var renderizarValidacao = function () {
        var erros = $("#erros");
        if (erros.length > 0) {
            var campos = JSON.parse(erros.attr('data'));

            $.each(campos, function (index, campo) {
                campo = campo.replace("[]", "");
                var campoEach = $("input[name='" + campo + "']");
                if (campoEach.length == 0)
                    campoEach = $("#" + campo);

                if (campoEach.length > 0)
                    campoEach.closest('div').addClass('has-error');
            });
        }
    }

    var alterarItem = function (e) {
        var grid = $("#gridtemplate");
        var tr = $(this).closest("tr");
        var classeSelecionada = 'k-state-selected';
        tr.addClass(classeSelecionada);
        var id = grid.obterLinhaGridItemId();

        location.href = obterUrlParaAcao() + "/alterar/" + id;
        e.preventDefault();
        return false;
    }

    var visualizarItem = function () {
        var grid = $("#gridtemplate");
        var tr = $(this).closest("tr");
        var classeSelecionada = 'k-state-selected';
        tr.addClass(classeSelecionada);
        var id = grid.obterLinhaGridItemId();

        location.href = obterUrlParaAcao() + "/visualizar/" + id;
    }

    var pesquisaOnChange = function () {
        $("#gridtemplate").getKendoGrid().dataSource.read(obterParametroGrid());
    }

    publico.comboBoxSelect = function (id, url, parametros) {
        var elemento = $("#" + id);
        elemento.select2({
            ajax: {
                url: url,
                delay: 350,
                type: "GET",
                data: function (params) {
                    return $.extend( {
                        parametro: params.term, 
                    }, $.isFunction(parametros) ? parametros(): {})
                },
                processResults: function (data, params) {
                    return {
                        results: $.map(data, function (item) {
                            return item;
                        })
                    };
                },
                cache: true
            },
            "language": "pt-BR",
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 2
        });
    }

    publico.init = function () {
        kendo.culture("pt-BR");
        $("#btnAtualizar").on("click", atualizar);
        $("#btnPesquisar").on("click", pesquisaOnChange);

        $("#gridtemplate").on("click", ".btn-warning", function (e) {
            e.preventDefault();
            alterarItem();
        });

        $("#gridtemplate").on("click", ".btn-xs.btn-default", function (e) {
            e.preventDefault();
            visualizarItem(e);

        });

        inicializarPlugins();
        inicializarAtalho();
        renderizarValidacao();
    };

    var inicializarPlugins = function () {
        $(".select2").select2({
            "language": "pt-BR"
        });

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });
    }

    var obterParametroGrid = function(){
        return {
                parametro : $("#inputPesquisa").val(),
                idFiltro: $("#idFiltro option:selected" ).attr('id'),
                dataInicial : $("#dataInicial").val(),
                dataFinal : $("#dataFinal").val(),
                pesquisarDatas: $(".pesquisaData").is(":visible"),
                idDropDrownList: $("#idDropDownList").val(),
        }
    }
    
    publico.gridtemplate = function (colunas, colunasConfiguracao, removerAlterar) {
        $("#gridtemplate").kendoGrid({
            columns: colunas ,
            pageable: {
                buttonCount: 10,
                pageSizes: true,
            },
            toolbar: kendo.template($("#template").html()),
            sortable: true,
            selectable: "multiple",
            filterable: true,
            messages: {
                noRecords: "Sem resultado."
            },
            dataSource: {
                transport: {
                    read: {
                        url: "/" + (document.URL).split("/")[3] + "/obtergridpesquisa",
                        data: obterParametroGrid()
                    }
                },
                pageSize: 10,
                schema: {
                    model: {
                        fields: colunasConfiguracao
                    }
                }
            },
            autoBind: false,
        });

        console.log(removerAlterar);
        setTimeout(function () {
            inicializarPlugins();

            if (!removerAlterar) 
                acaoAlterarDeletar();

        }, 120)
     }

    $("#gridtemplate").on("click", ".btn-danger", function (e) {
        e.preventDefault();
        var grid = $("#gridtemplate");
        var tr = $(this).closest("tr");
        var classeSelecionada = 'k-state-selected';
        tr.addClass(classeSelecionada);
        var id = grid.obterLinhaGridItemId();

        var url = obterUrlParaAcao() + "/excluir/" + id;

        swal({
            title: "Deseja realmente excluir ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Sim, quero deletar!',
            cancelButtonText: 'Não',
            closeOnConfirm: false
        },
        function () {
            $.get(url, function (data) {
                if(data){
                    $('body').html(data);
                }else{
                    grid.removerLinhaDoGrid();
                    tr.removeClass(classeSelecionada);
                    swal("Deletado!", "o registro foi deleta com sucesso!", "success");
                }
            })
        });
        
        return false;
    });

    return publico;
});

$(function(){
    $.namespace("gridtemplatejs").init();
});