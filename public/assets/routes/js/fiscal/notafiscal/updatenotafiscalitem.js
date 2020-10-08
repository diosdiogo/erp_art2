$.namespace('updatenotafiscalitem', function(){
    var publico = {};

    var acrescimomoeda = $("input[name='acrescimomoeda']");
    var descontomoeda = $("input[name='descontomoeda']");
    var valorunitario = $("input[name='valorunitario']");
    var valortotal = $($("input[name='valortotal']")[1]); 
    var quantidade = $("input[name='quantidade']");
    var descontoporcentagem = $("input[name='descontoporcentagem']");
    var recarregarQuantidadeQuadradoTexto = null;
    var recarregarQuantidadeMetroQuadrado = null;

    publico.init = function(){
        inicializarEventos();
    }

    var tratarValor = function(valor){
        if(valor == undefined)
            return 0;

        var retorno = valor.replace('.', '').replace(',','.');
        if(retorno < 0)
            return 0;
            
        return parseFloat(retorno);
    }

    var calcularValorTotalGet = function(){
        return setTimeout(function(){
            var url = "/notafiscal/calcularvalortotalitem";
            var parametro = {
                acrescimomoeda : tratarValor(acrescimomoeda.val()),
                descontomoeda : tratarValor(descontomoeda.val()),
                valorunitario : tratarValor(valorunitario.val()),
                quantidade : tratarValor(quantidade.val()),
                descontoporcentagem : tratarValor(descontoporcentagem.val())
            };

            $.get(url, parametro, function(data){
                valortotal.val($.fn.dataTable.render.number('.', ',', 2, "R$").display(data));
            });
        }, 1000);
    }

    var calcularValorTotal = function(){
        clearTimeout( calcularValorTotalGet )
        calcularValorTotalGet();
    }

    var inicializarEventos = function(){
        acrescimomoeda.on("change", calcularValorTotal);
        descontomoeda.on("change", calcularValorTotal);
        valorunitario.on("change", calcularValorTotal);
        valorunitario.on("blur", calcularValorTotal);
        valorunitario.on("input", calcularValorTotal);
        quantidade.on("input", calcularValorTotal);
        descontoporcentagem.on("input", calcularValorTotal);
        $("input[name='altura']").on("change", alterarRecarregarQuantidadeMetroQuadrado);
        $("input[name='altura']").on("keypress", alterarRecarregarQuantidadeMetroQuadrado);
        $("input[name='largura']").on("change", alterarRecarregarQuantidadeMetroQuadrado);
        $("input[name='largura']").on("keypress", alterarRecarregarQuantidadeMetroQuadrado);
        updatetemplatejs.comboBoxSelect("idproduto", "/notafiscal/obterproduto");
        inicializarEventoProduto();

        shortcut.add("INSERT", function (e) {
            $("#salvarItem").trigger('click');
        });  

        iniciarlizarEventoCheckQuadrado();
    }

    var iniciarlizarEventoCheckQuadrado = function(){
        var checkBox = $('input[type="checkbox"].flat-red, input[type="radio"].flat-red');

        checkBox.iCheck({ checkboxClass: 'icheckbox_flat-blue', radioClass: 'iradio_flat-blue'});
        checkBox.on('ifToggled', alterarValorICheck);
    }

    var alterarRecarregarQuantidadeMetroQuadrado = function(){
        clearTimeout(recarregarQuantidadeMetroQuadrado);
        recarregarQuantidadeMetroQuadrado = setTimeout(recarregarQuantidadeMetroQuadradoInterno, 500);
    }

    var recarregarQuantidadeMetroQuadradoInterno = function(){
        if($.isNotNullAndNotEmpty($("input[name='largura']").val())){
            var resultado = Number($("input[name='altura']").val().replace(",", ".")) * Number($("input[name='largura']").val().replace(",", "."));
            $("input[name='quantidade']").val($.toMoneySimples(resultado));
            $("input[name='quantidade']").trigger("input");
        }
    }

    var alterarValorICheck = function (event) {
        var that = $(this);
        var status = that.is(":checked");
        var checkHelper = $("input[name='" + that.attr('name').replace("check_", "") +"']");
        if(checkHelper)
            checkHelper.attr("value", status ? "true" : "false");
    };

    var inicializarEventoProduto = function(){
        var produto = $("#idproduto");
        produto.on("change", produtoOnChange);

        if(produto.isNullOrEmpty()){
            produto.selectOpen();
            $("input[type='search']").focus();
        }else
            setarDescricaoProduto();
        
    }

    var setarDescricaoProduto = function(){
        $("#descricao").val($("#select2-idproduto-container").text());
    }

    var produtoOnChange = function(e){
        setarDescricaoProduto();
        $("input[name='valorunitario']").tryFocus();
        var produto = $("#idproduto").select2('data')[0];
        $("input[name='valorunitario']").val(produto.preco).trigger('input');
    }

    return publico;
});

$(function() {
    $.namespace('updatenotafiscalitem').init();
});

