$.namespace("gridnotafiscal", function () {
    var publico = {};

    var consultarOnClick = function () {
        $.loading();
        var url = "/notafiscal/consultarstatussefaz";
        var parametro = { idEmpresa: $("#idempresa").val() || $.getIdEmpresa() };
        $.get(url, parametro, function (data) {
            swal(data);
            $.removeLoading();
        });
    }

    var verificarAlertaAutomaticoEnviar = function () {
        return $.actionConcluirEdicaoIsValid() && ($(".callout").length == 0 || $("#divErros").is(":hidden"));
    }

    var enviarNotaFiscalConcluirEdicao = function () {
        if (verificarAlertaAutomaticoEnviar())
            enviarNotaFiscal($.obterIdConcluirEdicao());
    }

    var inutilzacaoOnClick = function () {
        $("#notaFiscalInutilizacao").modal('show');
    }

    var enviarNotaFiscalInutilizavaoOnClick = function () {
        $("#btnEnviarInutilizacao").on("click", function (e) {
            var url = "/notafiscal/inutilizar";

            var parametros = {
                numeroInicial: $("#numeroInicial").val(),
                numeroFinal: $("#numeroFinal").val(),
                justificativa: $("#justificativa").val()
            }


            if ($("#numeroInicial").val() && $("#numeroFinal").val() && $("#justificativa").val() && $("#justificativa").val().length >= 25) {
                $.loading();
                $.get(url, parametros, function (data) {
                    if (Object.keys(data) == "102") {
                        limparCamposInutilizacao();
                        $("#notaFiscalInutilizacao").modal('toggle');
                    }

                    swal(Object.values(data)[0]);

                    $.removeLoading();
                }).fail(function (erro) {console.log(erro) });
            } else {
                swal("Todos os campos são obrigatórios, o campo justificativa deve conter de 25-255 caracteres");
            }
        });

        $("#btnCancelarInutilizacao").on("click", function () {
            limparCamposInutilizacao();
        });
    }

    var limparCamposInutilizacao = function () {
        $("#numeroInicial").val("");
        $("#numeroFinal").val("");
        $("#justificativa").val("");
    }

    var enviarNotaFiscalOnClick = function () {
        enviarNotaFiscal();
    }

    var cancelarOnClick = function () {
        var gridTemplate = $("#gridtemplate");
        var notaFiscal = gridTemplate.obterLinhaGridItem();
        var codigo = id || notaFiscal.id;

        var url = "/notafiscal/cancelar";
        var parametro = { id: codigo };
        swal({
            title: "Deseja cancelar  a Nota Fiscal",
            text: "Após clicar em [OK], aguarde...",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
            function (isConfirm) {
                if (isConfirm) {
                    $.get(url, parametro, function (data) {
                        $(".sweet-alert").hide();
                        $(".sweet-overlay").hide();
                        if (!$.validarErrorGrid(data)) {
                            swal("Nota fiscal cancelada com sucesso!!!");
                            gridTemplate.getKendoGrid().dataSource.read({ 'id': codigo });
                        }
                    }).fail(function (data) {
                        $.validarErrorGrid(data);
                    });;
                }
            });
    }

    var enviarNotaFiscal = function (id) {
        var gridTemplate = $("#gridtemplate");
        var notaFiscal = gridTemplate.obterLinhaGridItem();
        var situacaoEnviar = notaFiscal != null ? (notaFiscal.idnotafiscalsituacao == 6 || notaFiscal.idnotafiscalsituacao == 7) : 0;
        var codigo = id || notaFiscal.id;

        if (situacaoEnviar) {
            var url = "/notafiscal/enviarnotafiscal";
            var parametro = { id: codigo };
            swal({
                title: "Deseja enviar  a Nota Fiscal",
                text: "Após clicar em [OK], aguarde...",
                type: "info",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
            },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get(url, parametro, function (data) {
                            $(".sweet-alert").hide();
                            $(".sweet-overlay").hide();
                            if (!$.validarErrorGrid(data))
                                swal("Nota fiscal enviada com sucesso!!!");

                            //gridTemplate.getKendoGrid().dataSource.read({ 'id': '' + codigo });
                        }).fail(function (data) {
                            $.validarErrorGrid(data);
                            gridTemplate.getKendoGrid().dataSource.read({ 'id': codigo });
                        });;
                    }
                });
        }
    }

    var imprimirDanfeOnClick = function (e) {
        $.executarChamadaAjaxGrid(e, function () {
            var grid = $("#gridtemplate");
            var url = "/notafiscal/visualizardanfe/" + "?id=" + grid.obterLinhaGridItemId();
            window.open(url, "_blank");
        });
    }

    var baixarArquivoOnClick = function (e) {
        $.executarChamadaAjaxGrid(e, function () {
            var grid = $("#gridtemplate");
            var url = "/notafiscal/baixardanfe/" + "?id=" + grid.obterLinhaGridItemId();
            window.open(url, "_blank");
        });
    }

    var enviarEmailOnClick = function () {
        swal("Desenvolvimento [Enviar e-mail]");
    }

    publico.inicializarEventosCompartilhados = function () {
        $("#btnEnviarEmail").on("click", enviarEmailOnClick);
        $("#btnBaixarArquivo").on("click", baixarArquivoOnClick);
        $("#btnImprimir").on("click", imprimirDanfeOnClick);
        $("#btnEnviar").on("click", enviarNotaFiscalOnClick);
        $("#btnConsultarStatus").on("click", consultarOnClick);
        $("#btnCancelar").on("click", cancelarOnClick);
        $("#btnInutilizar").on("click", inutilzacaoOnClick);
        enviarNotaFiscalInutilizavaoOnClick();
    }

    var gridTemplateDataBinding = function () {
        setTimeout(function () {
            if ($.obterIdConcluirEdicao() > 0) {
                var grid = $("#gridtemplate");
                var tr = grid.find("tr");
                if (tr.length > 1) {
                    var classeSelecionada = 'k-state-selected';
                    $(tr[1]).addClass(classeSelecionada);
                    enviarNotaFiscalConcluirEdicao();
                }
            }
        }, 250);
    }

    publico.init = function () {
        publico.inicializarEventosCompartilhados();

        if ($.gridTemplateValido())
            $("#gridtemplate").getKendoGrid().bind('dataBinding', gridTemplateDataBinding);
    }

    return publico;
});

$(function () {
    $.namespace("gridnotafiscal").init();
})