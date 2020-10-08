 $.namespace("gridpessoa", function(){
    var publico = {};

    var inicializarTabela = function(){
   
    }

    publico.formatarStatus = function(lista){
        var texto = "";
        var listaSplit = lista.split(".");
        var listaTipo = "primary.danger.success".split(".");

        for (i = 0; i < listaSplit.length; i++)
            texto += ('<span class="label label-' + listaTipo[i] + '" style="margin-left:5px">' + listaSplit[i] + '</span>');

        return texto;
    }
    
    publico.init = function(){
        inicializarTabela();
    };

    return publico;
});

$(function(){
    $.namespace("gridpessoa").init();
});