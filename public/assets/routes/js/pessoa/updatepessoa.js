 $.namespace("updatepessoa", function(){
    var publico = {};

    var inicializarTabela = function(){

    }

    var abrirSiteOnClick = function () {
        $("#site").abrirLinkPaginaEmBrancoComponente($(this).val());
    }

    var pessoaSexoOnChange = function (name, evt) {
        var that = $(this).val();
        var contribuinte = $("#idpessoatipocontribuinte");
        var sexo = $("#idpessoasexo");
        var cpfoucnpj = $("#cpfoucnpj");
        //var rgouinscricaoestadual = $("input[name='rgouinscricaoestadual']");
        // Fisica
        if (that == "1") {
            contribuinte.desabilitar();
            sexo.habilitar();
            contribuinte.val("1").trigger('change');
            cpfoucnpj.removeClass("cpfcnpj");
            cpfoucnpj.addClass("cpf");

            /*rgouinscricaoestadual.removeClass("ie");
            rgouinscricaoestadual.addClass("rg");*/
        // Juridica
        } else if (that == "2") { 
            contribuinte.habilitar();
            sexo.desabilitar();
            cpfoucnpj.removeClass("cpf");
            cpfoucnpj.addClass("cnpj");

            /*rgouinscricaoestadual.removeClass("rg");
            rgouinscricaoestadual.addClass("ie");*/
        }
    }

    var iniciarlizarMascaras = function () {
        $('.rg').mask('00.000.000-0');
    }
    
    var inicializarEventos = function () {
        updatetemplatejs.comboBoxSelect("idcidade", "/pessoa/obtercidade");
        $("#btnSite").on("click", abrirSiteOnClick);
        $("#idpessoatipo").on("change", pessoaSexoOnChange);

        setTimeout(function () {
            $("#idpessoatipo").change();
        }, 100);
    }

    publico.init = function(){
        inicializarTabela();
        inicializarEventos();
        iniciarlizarMascaras();
    };

    return publico;
});

$(function(){
    $.namespace("updatepessoa").init();
});