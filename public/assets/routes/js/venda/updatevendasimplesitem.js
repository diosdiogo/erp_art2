$.namespace('updatevendaitemsimples', function(){
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
            var url = "/vendasimples/calcularvalortotalitem";
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
        updatetemplatejs.comboBoxSelect("idproduto", "/vendasimples/obterproduto");
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
        checkBox.on('ifToggled', inserirQuantidadeQuadradoOnClick);
        $("#btnAtualizarQuadrado").on("click", inserirQuantidadeQuadradoOnClick);
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

    publico.alterarQuatidadeQuadradoTexto = function(){
        clearTimeout(recarregarQuantidadeQuadradoTexto);
        recarregarQuantidadeQuadradoTexto = setTimeout(alterarQuatidadeQuadradoTextoInterno, 500);
    }

    var alterarQuatidadeQuadradoTextoInterno = function(){
        var resultado = "";
        $.each($(".quantidadeQuadradoClass"), function (e, elemento) { resultado += $(elemento).val() + ";"; });
        var valorQuadrado = resultado.substring(0, resultado.length - 1);
        $("#quantidadequadradotexto").val(valorQuadrado);
        alterarQuantidadeTotalQuadrado();
    }

    var alterarQuantidadeTotalQuadrado = function(){
        var resultado = 0;
        $.each($(".quantidadeQuadradoClass"), function(e, elemento){ resultado += Number($(elemento).val().replace(",", ".")); });
        $("input[name='quantidade']").val($.toMoneySimples(resultado, 3));
        $("input[name='quantidade']").trigger("input");
    }

    var inserirQuantidadeQuadradoOnClick = function(e){
        var carregarQuadrados = $("input[name='quantidadequadrado']").val();
        if($.parseBool(carregarQuadrados) && $.parseBool($("input[name='quantidadepeca']").val() > 1)){
            inserirQuantidadeQuadradoOnClickPrivado(e);
            $("#divQuadrados").show();
            $("#quantidade_1").focus();
        }else
            $("#divQuadrados").hide();    
    }

    var inserirQuantidadeQuadradoOnClickPrivado = function(e){
        var url = "/vendasimples/inserirquantidadequadrado";
        var quantidade = $("input[name='quantidadepeca']").val();
        var gerarQuadrado = $("input[name='quantidadequadrado']").val();
        var id = $("input[name='id']").val();
        var parametro = { quantidade : quantidade, gerarQuadrado : gerarQuadrado, id : id};
        $.get(url, parametro, function(data){
            $("#divQuadrados").html(data);
        });
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

    var produtoOnChange = function (e) {
        setarDescricaoProduto();
        var produto = $("#idproduto").select2('data')[0];
        $("input[name='valorunitario']").tryFocus();
        $("input[name='valorunitario']").val(produto.preco).trigger('input');
        adicionarCampoProdutoDiverso(produto);
        if($("#alertaPreco").length > 0)    
            obterValorUnitarioUltimoPedido();
    }

    var adicionarCampoProdutoDiverso = function (produto) {
        var divProduto = $("#divProduto");
        if (produto.id == 1) {
            divProduto.show();
        } else {
            divProduto.hide();
        }
    }

    var obterValorUnitarioUltimoPedido = function(){
        var url = "/vendasimples/obtervalorunitarioultimopedido";

        var parametros = {
            "idproduto" : $("#idproduto").val(),
            "idpessoa" : $("#idpessoa").val()
        };

        $.get(url, parametros, function(data){
            if($.isNotNullAndNotEmpty(data)){
                var valorUnitario = data[0].valorunitario;
                if(valorUnitario != null && valorUnitario != 0){
                    $("#alertaPreco").show();
                    $("#ultimoPrecoPedido").text("R$" + $.toMoneyVenda(valorUnitario));
                }else
                    $("#alertaPreco").hide();
            }else
                $("#alertaPreco").hide();
        });
    }

    return publico;
});

$(function() {
    $.namespace('updatevendaitemsimples').init();
});

