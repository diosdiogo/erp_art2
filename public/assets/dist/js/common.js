$.namespace("common", function () {
    var publico = {};

    var inicializarAtalho = function () {
        var url = document.URL;

        var emDesenvolvimento = function () {
            alert("Em desenvolvimento");
        }

        shortcut.add("Ctrl+1", function (e) {
           e.preventDefault();
           abrirUrl("/vendasimples/");
        });

        shortcut.add("Ctrl+2", function (e) {
            e.preventDefault();
            abrirUrl("/relatoriovenda/");
        });

        shortcut.add("Ctrl+3", function (e) {
            e.preventDefault();
            abrirUrl("/pessoa/");
        });

        shortcut.add("Ctrl+P", function (e) {
            e.preventDefault();
            $('#dropdown-busca').addClass('open');
            $("#buscar_menu").focus();
        });

        shortcut.add("Ctrl+4", function (e) {
            e.preventDefault();
            abrirUrl("/produto");
        });

        shortcut.add("Ctrl+9", function (e) {
            e.preventDefault();
            abrirUrl("/vendasimples/inserir");
        });

        shortcut.add("Ctrl+10", function (e) {
            e.preventDefault();
            abrirUrl("/venda/inserir");
        });

        shortcut.add("Ctrl+0", function (e) {
            e.preventDefault();
            abrirUrl("/venda/inserir");
        });

        shortcut.add("ESC", function (e) {
            e.preventDefault();
            $('div[role="dialog"]').modal('hide');
        });
    }

    var abrirUrl = function(url){
        location.href = url;
    }

    var limparSelecaoMenu = function () {
        var sidebar = $(".sidebar-menu li");
        sidebar.removeClass("active");
        sidebar.removeClass("menu-open");
    }

    var setarConfiguracaoMenu = function () {
        limparSelecaoMenu();

        var menus = $(".sidebar-menu a");
        
        $.each(menus, function (index, elemento) {
            elemento = $(elemento);
            var url = elemento.attr('href');

            var urlComparacao = "/" + (document.URL).split("/")[3];

            if (url.includes(urlComparacao)) {
                var li = elemento.closest('li');
                li.closest('.treeview').addClass("active");
                li.closest('.treeview-menu').addClass("menu-open");
                li.addClass("active");
            }
        });
    }

    var userException = function(message) {
        this.message = message;
        this.name = "Mobi exception";
    }

    var globais = function(){

        $.minimizarEBloquearMenuLateral = function(){
            $("body").addClass("sidebar-collapse");
            $("body").removeClass("fixed");
        } 

        String.prototype.replaceAll = function(search, replacement) {
            var target = this;
            return target.replace(new RegExp(search, 'g'), replacement);
        };
        
        $.loading = function(){
            var over = '<div id="overlay">' +
                '<div id="loading">' +
                '</div>';
            $(over).appendTo('body');
        }

        $.getIdEmpresa = function(){
            var comboEmpresa = $("#idempresa :selected");
            var idEmpresa = 0;

            if(comboEmpresa.length > 0)
                idEmpresa = $("#idempresa :selected").attr("id");
            else
                throw new userException("idEmpresa não selecionado");
                
            return idEmpresa;
        }

        $.removeLoading= function(){
            $('#overlay').remove();
        }

        $.dateFormate = function(data){
            var dataFormatada = data;
            if(!data.includes("/")){
                var dataJS = new Date(data);
                dataFormatada = (dataJS.getUTCDate().toString().length == 1 ? "0" + dataJS.getUTCDate() : dataJS.getUTCDate()) + "/" + (dataJS.getUTCMonth().toString().length == 1 ? "0" + (dataJS.getUTCMonth() + 1) : (dataJS.getUTCMonth() + 1)) + "/" + dataJS.getFullYear();
            }
            
            return dataFormatada;
        }

        var setarFocus = function(elemento){
            if(elemento.is(":focus"))
                return;
            else{
                elemento.focus().select();
                setTimeout(function() {
                    setarFocus(elemento);
                }, 100);
            }
        }

        $.bloquearSairDaTela = function(){
            setTimeout(function(){
                    window.onbeforeunload = function() {
                        return "É possivel que as alterações feitas não sejam salvas.";
                    }
                }, 500);
        }

        $.limparBloqueioSairDaTela = function(){
            window.onbeforeunload = function() {
                return null;
            }
        }

        $.obterUrlParaAcao = function () {
            return "/" + (document.URL).split("/")[3];
        }

        $.actionConcluirEdicaoIsValid = function(){
            return document.URL.split("/")[4] == "concluiredicao";
        }

        $.obterIdConcluirEdicao = function(){
            return document.URL.split("/")[5];
        }

        $.gridTemplateValido = function(){
            return $("#gridtemplate").length > 0 && $.isFunction($("#gridtemplate").getKendoGrid) && $("#gridtemplate").getKendoGrid() != undefined;
        }

        $.fn.tryFocus = function(){
            var elemento = $(this);
            setarFocus(elemento);
        }

        $.toMoney = function(texto){
            texto = ($.isNotNullAndNotEmpty(texto) ?  (texto+ "") : "0");
            return $.fn.dataTable.render.number('.', ',', 2, "R$").display(texto.replace(",", "."));
        }

        $.toMoneyVenda = function(valor){
            return $.toMoneyVendaSimples(valor, true);
        }

        $.tratarValor = function (valor) {
            if (valor == undefined)
                return 0;

            var retorno = valor.replace('.', '').replace(',', '.');
            if (retorno < 0)
                return 0;

            return parseFloat(retorno);
        }

        $.toMoneyVendaSimples = function(valor, gerarTexto){
            if(valor == undefined)
                return 0.00;

            if($.isNumeric(valor)){
                if(valor == "0.00")
                    return 0.00;
                
                var novoValor = (valor + "").split('.');
                if(novoValor.length == 2 && (valor + "").split('.')[1].length >= 2 )
                    return $.toMoneySimples(novoValor);
                else if(novoValor.length == 2 && (valor + "").split('.')[1].length == 1)
                    return $.toMoneySimples(novoValor + "0");

                valor = valor + "".replace(".", ",") + ".00";
            }

            var resultado = ""; 
            var numeros = valor.split(",");
            var quantidadeSplit = numeros.length;

            $.each(numeros, function(index, elemento){
                if(quantidadeSplit == (index + 1))
                    resultado += elemento.replace(".", ",") + ".";
                else
                    resultado += elemento + ".";
            });

            return  (gerarTexto ? "R$" : "") + resultado.substring(0, resultado.length - 1);
        }

        $.toMoneySimples = function (texto, casasDecimais) {
            texto = ($.isNotNullAndNotEmpty(texto) ?  (texto+ "") : "0");
            return $.fn.dataTable.render.number('.', ',', casasDecimais == undefined ? 2 : casasDecimais, "").display(texto.replace(",", "."));
        }

        $.fn.isNotNullNotEmpty = function(){
            var elemento = $(this);
            return elemento.val() != null && elemento.val() != undefined && elemento.val() != ""; 
        }

        $.fn.isNotNullAndNotEmpty = function(){
            var elemento = $(this);
            return $.isNotNullAndNotEmpty(elemento.val()); 
        }

        $.parseBool = function(texto){
            return texto == "true" || texto == "1" || texto == true;
        }

        $.isNotNullAndNotEmpty = function(texto){
            return texto != null && texto != undefined && texto != ""; 
        }

        $.fn.isNullOrEmpty = function(){
            var elemento = $(this);
            return elemento.val() == null || elemento.val() == undefined || elemento.val() == ""; 
        }

        $.FormularioAlterar = function(){
            return $("input[name='cod']").val() > 0;
        }

        $.firstOrDefaultId = function(lista, id){
            var retorno = null
            $.each(lista, function(index, elemento){
                if(elemento.id == id){
                    retorno = elemento;
                    return false;
                }
            });

            return retorno;
        }

        $.fn.selectOpen = function(){
            $(this).select2('open');
        }

        $.executarChamadaAjaxGrid = function(e, funcaoChamada){
            e.preventDefault();
            var grid = $("#gridtemplate");
            var linha = grid.obterLinhaGridItem();
            
            if (linha == null) {
                sweetAlert("Alerta!", "Selecione um registro", "error");
            }else{
                $.loading();
                funcaoChamada();
                $.removeLoading();
            }
        }

        $.validarErrorGrid = function(retorno){
            var mensagem = retorno['error'];
            if($.isNotNullAndNotEmpty(mensagem)){
                $("#divErros").show();
                $("#divErros").html('<div class="callout callout-danger bg-red disabled color-palette">' +
                                    '    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                    '    <h4>Alerta!</h4>' +
                                    '    <div id="erros" hidden data="{!! json_encode(array_keys($errors->default->messages())) !!}"></div>' +
                                    '    <ul>' +
                            '               <li>'+ mensagem +'</li>' +
                                    '    </ul>' +
                                    '</div>' );
                var gridTemplate = $("#gridtemplate");
                var item = gridTemplate.obterLinhaGridItem();
                gridTemplate.getKendoGrid().dataSource.read({ 'id': item.id });
                return true;
            }else{
                $("#divErros").hide();
                return false;
            }
        }

        $.textToFloat = function(text){
            if(text.length == 5)
                text = text.replace(",", ".");

            var cleanText = Number(text.replace(/[^0-9\.]+/g,""));

            if(cleanText.length == 5)
                return parseFloat(cleanText);
                
            return parseFloat(cleanText) * 1000;
        }
    }


    publico.init = function () {
        inicializarAtalho();
        setarConfiguracaoMenu();
        globais();
    }

    return publico;
});

$(function () {
    $.namespace("common").init();
});
