 $.namespace("updatefiscalnaturezaoperacao", function(){
    var publico = {};

   
    publico.init = function () {
        updatetemplatejs.comboBoxSelect("idfiscalCFOPDentroEstado", "/fiscalnaturezaoperacao/obtercfop");
        updatetemplatejs.comboBoxSelect("idfiscalCFOPForaEstado", "/fiscalnaturezaoperacao/obtercfop");
    };

    return publico;
});

$(function(){
    $.namespace("updatefiscalnaturezaoperacao").init();
});