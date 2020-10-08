$.namespace("gridproduto", function () {
    var publico = {};
    var btnInserirEstoque = $("#btnInserirEstoque");

    var inserirEstoqueOnClick = function (e) {

        var grid = $("#gridtemplate");
        var linha = grid.obterLinhaGridItem();
        if (linha == null) {
            e.preventDefault();
            sweetAlert("Alerta!", "Selecione um produto", "error");
        }

        var id = grid.obterLinhaGridItemId();
        location.href = '/produtoestoque' + "/alterar/" + id;

        e.preventDefault();
    }

    publico.init = function () {
        btnInserirEstoque.on("click", inserirEstoqueOnClick);
    }
    
    return publico;
});

$(function () {
    $.namespace("gridproduto").init();
});