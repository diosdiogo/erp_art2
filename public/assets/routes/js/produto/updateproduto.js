$.namespace("updateproduto", function () {
    var publico = {};
    var custoCompra = $("input[name='custocompra']");
    var preco = $("input[name='preco']");
    var margemLucro = $("#margemlucro");
    var boxmoney = $("#box-money");

    var calcularLucroChange = function () {
        var porcentagem = "<small>%</small>";
        removerClassesBoxMoney();
        var precoNumero = parseFloat(preco.val().replace('.', '').replace(',','.'));
        var custoCompraNumero = parseFloat(custoCompra.val().replace('.', '').replace(',', '.'));

        if (precoNumero > 0 && custoCompraNumero > 0) {
            var margem = ((((custoCompraNumero - precoNumero) / custoCompraNumero) * 100) * -1);
            if (margem > 0) {
                boxmoney.addClass('bg-green');
            } else if (margem == 0) {
                boxmoney.addClass('bg-blue');
            } else {
                boxmoney.addClass('bg-red');
            }

            margemLucro.html(margem + "" + porcentagem);
        } else {
            boxmoney.addClass('bg-blue');
            margemLucro.html("0" + porcentagem);
        }
    };

    var habilitarBalancaOnChange = function (event) {
        var that = $(this);
        var status = that.is(":checked");
        var codigobalanca = $("input[name='codigobalanca']");

        if (status)
            codigobalanca.habilitar();
        else
            codigobalanca.desabilitar();
    };

    var removerClassesBoxMoney = function () {
        boxmoney.removeClass('bg-blue');
        boxmoney.removeClass('bg-green');
        boxmoney.removeClass('bg-red');
    };

    var inicializarEventos = function () {
        updatetemplatejs.comboBoxSelect("idfiscalcest", "/produto/obtercest");
        updatetemplatejs.comboBoxSelect("idfiscalncm", "/produto/obterncm");
        updatetemplatejs.comboBoxSelect("idpessoafornecedor", "/produto/obterpessoafornecedor");
        
        $("input[name='check_habilitabalanca']").on('ifToggled', habilitarBalancaOnChange);
        custoCompra.on("change", calcularLucroChange);
        preco.on("change", calcularLucroChange);
    };

    publico.init = function () {
        inicializarEventos();

        setTimeout(function () {
            custoCompra.trigger("change");
            preco.trigger("change");
        }, 100)
    };

    return publico;
});

$(function () {
    $.namespace("updateproduto").init();
});