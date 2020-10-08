$.namespace("notificacao", function () {
    var publico = {};

    var notificacaoMenuShow = function (){
        var url = "/home/alterarnotificacoesparalida";
        $.get(url, function(data){
            console.log(data);
        });
    }

    var inicializarEventos = function (){
        $('.messages-menu').on('show.bs.dropdown', notificacaoMenuShow);
    }

    publico.init = function(){
        inicializarEventos();
    }

    return publico;
});

$(function(){
    $.namespace("notificacao").init();
});
