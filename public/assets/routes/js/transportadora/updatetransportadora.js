 $.namespace("updatetransportadora", function(){
    var publico = {};

    var inicializarTabela = function(){

    }

    publico.init = function () {
        inicializarTabela();
    };

    return publico;
});

$(function(){
    $.namespace("updatetransportadora").init();
});