$.namespace('gridvendas', function(){
    var publico = {};

    publico.init = function(){
        inicializarEventos();
    }

    var inicializarEventos = function(){
        $("#btnFaturar").on("click", faturarOnClick);
        $("#btnImprimir").on("click", imprimirOnClick);        
        $("#btnNotaFiscal").on("click", gerarNotaFiscal);
        $("#btnReabrir").on("click", reabrirOnClick);
    }

    var obterIdsSelecionadoGridTemplate = function () {
        var gridTemplate = $("#gridtemplate").getKendoGrid();
        var itens = gridTemplate.select();
        var texto = [];
        $.each(itens, function (index, elemento) {
            texto.push(gridTemplate.dataItem(elemento).id);
        });

        return texto;
    }

    var reabrirOnClick = function (e) {
        $.executarChamadaAjaxGrid(e, function () {
            var grid = $("#gridtemplate");
            location.href = "/vendasimples/reabrir/?id=" + grid.obterLinhaGridItemId();
        });
    }

    var gerarNotaFiscal = function(e){
        $.executarChamadaAjaxGrid(e, function(){
            var grid = $("#gridtemplate");
            var id = grid.obterLinhaGridItemId();
            var urlValidacao = "/notafiscal/validarnotafiscalorigemvenda?id=" + id;
            $.get(urlValidacao, function (data) {
                if(data == "" || !$.validarErrorGrid(data)){
                    var url = "/notafiscal/inserir?origem=1&id=" + id;
                    window.open(url,'_blank');
                }
            });
        });
            // var parametro = {"id" : grid.obterLinhaGridItemId()};
            // swal({
            //         title: "Deseja gerar a Nota Fiscal",
            //         text: "Após clicar em [OK], aguarde...",
            //         type: "info",
            //         showCancelButton: true,
            //         closeOnConfirm: false,
            //         showLoaderOnConfirm: true,
            //     },
            //     function(){
            //         $.get(url, parametro, function(data){
            //             swal("Nota fiscal enviada com sucesso!!!");
            //         });
            //     })
            // });        
    }

    var faturarOnClick = function(e){
        $.executarChamadaAjaxGrid(e, function(){
            var grid = $("#gridtemplate");
            var url = "/vendasimples/faturar/";
            location.href = "/vendasimples/faturar/?id=" + grid.obterLinhaGridItemId();
        });
    }

    var imprimirOnClick = function(e){
        $.executarChamadaAjaxGrid(e, function(){
            var grid = $("#gridtemplate");
            var url = "";
            var parametro = obterIdsSelecionadoGridTemplate();
            if (parametro.length > 1) {
                url = "/vendasimples/imprimirvarios/" + "?id=" + parametro;
            }else{
                url = "/vendasimples/imprimir/" + "?id=" + grid.obterLinhaGridItemId();
            }

            window.open(url, "_blank");
        });        
    }
  
    return publico;
});

$(function() {
    $.namespace('gridvendas').init();
});