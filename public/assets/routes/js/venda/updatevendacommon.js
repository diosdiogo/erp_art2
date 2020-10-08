$.namespace('updatevendacommon', function(){
    var publico = {};

    publico.init = function(){
        inicializarEventos();
    }

    var inicializarEventos = function(){
        console.log("1212");
    }

    return publico;
});

$(function() {
    $.namespace('updatevendacommon').init();
});