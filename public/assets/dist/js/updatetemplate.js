var namespaceTexto = "updatetemplatejs";

 $.namespace(namespaceTexto, function(){
    var publico = {};

    var renderizarValidacao = function () {
        var erros = $("#erros");
        if (erros.length > 0) {
            var campos = JSON.parse(erros.attr('data'));

            $.each(campos, function (index, campo) {
                campo = campo.replace("[]", "");
                var campoEach = obterElementoPorTipo(campo);
                if (campoEach.length > 0){
                    if(campoEach.is("select"))
                        campoEach.select2().data('select2').$container.addClass("has-error");
                    else
                        campoEach.closest('div').addClass('has-error');
                }
            });
        }
    }

    var obterElementoPorTipo = function (nome){
        var campo = $("#" + nome);
        var tipos = ['input', 'select', 'textarea'];

        if(campo.length == 0){
            $.each(tipos, function(index, elemento){
                campo = $(elemento + "[name='" + nome + "']");

                if(campo.length > 0)
                    return false;
            });
        }

        return campo;
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
                            return item;// { id: item.id, text: item.text, adicional : item.adicional };
                        })
                    };
                },
                cache: true
            },
            "language": "pt-BR",
            escapeMarkup: function (markup) { return markup; },
            minimumInputLength: 1
        });
    }

    var inicializarPlugins = function () {
        $("[data-mask]").inputmask();
        $(".select2").select2({
            "language": "pt-BR"
        });

        $(".datepicker").datepicker({
            autoclose: true
        });

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').on('ifToggled', alterarValorICheck);
    }

    var alterarValorICheck = function (event) {
        var that = $(this);
        var status = that.is(":checked");
        var checkHelper = $("input[name='" + that.attr('name').replace("check_", "") +"']");
        if(checkHelper)
            checkHelper.attr("value", status ? "true" : "false");
    };

    var visualizarUpdate = function () {
        var visualizar = (document.URL).split("/")[4] == "visualizar";

        if (visualizar) {
            $("#btnSalvar").desabilitar();
            $("form :input").prop("disabled", true)
            setTimeout(function() {
                $.limparBloqueioSairDaTela();
            }, 350);
        }
    }

    publico.atalhoCancelar = function(e){
          e.preventDefault();
           var url = $(".btnCancelar").attr('href');
           if($(".btnCancelar").length > 0 && url != undefined)
                location.href = url;
    }

    var inicializarAtalho = function () {
        shortcut.add("F2", function (e) {
            $.limparBloqueioSairDaTela();
            publico.atalhoCancelar(e);
        });
    }

    var iniciarlizarMascaras = function () {
        $('.date').mask('00/00/0000');
        $('.cep').mask('00000-000');
        $('.phone').mask('0000-0000');
        $('.placa').mask('AAA-0000');
        $('.date_time').mask('00/00/0000 00:00:00');
        $('.cell_with_ddd').mask('(00) 00000-0000');
        $('.phone_with_ddd').mask('(00) 0000-0000');
        $('.cpf').mask('000.000.000-00', { reverse: true });
        $('.cnpj').mask('00.000.000/0000-00', { reverse: true });
        $('.money').mask("#.##0,00", { reverse: true });
        $('.trescasasdecimais').mask("#.##0,000", { reverse: true });
        $('.porcentagem').mask('##0,00%', {reverse: true});
    }

    var inicializarEventos = function(){
        $("#btnSalvar").click(salvarOnClick);
        shortcut.add("Enter", function(e){
            var elementoSelect2Fechado = !$(e.srcElement).attr("class").includes("select2");
            var elementoSemFocus = !$(e.target).is(':focus');
            var modalFechado =  $(".modal.fade.in").length == 0;

            if(elementoSelect2Fechado && elementoSemFocus && modalFechado)
                $("#btnSalvar").trigger("click");
        });
    }
    
    var salvarOnClick = function(e){
        $(this).text("Salvando...");
        $(this).desabilitar();
        $.loading();
        $("#formPrincipal").submit();
    }

    publico.init = function () {
        inicializarEventos();
        inicializarPlugins();
        renderizarValidacao();
        visualizarUpdate();
        iniciarlizarMascaras();
        inicializarAtalho();
    };

    $(window).scroll(function () {
        var posicao = $(this).scrollTop();
        var nav = $(".nav-opcoes");
        
        if (posicao => 40)
            nav.css({ "top": "0px" });
        if (posicao < 40) 
            nav.removeAttr("style");
    })

    return publico;
});

$(function(){
    $.namespace(namespaceTexto).init();
});