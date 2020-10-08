$.namespace('updatenotafiscalutilitario', function(){
    var publico = {};
    var gridElemento = $('#griditem');
    var gridElementoParcela = $("#griditemparcela");
    var alterar = false;
    var modalNotaFiscalItem = $('#itemNotaFiscalModal');
    var carregarGridParcela = null;
    var carregarGridParcelaAlterar = 0;
    var idFormaRecebimentoItem = $("select[name='idformarecebimentoitem']");
    var formNotaFiscalItem = $("#form-item");
    var alterarVenda = $("#action").val() == "alterar";
    var permiteAtualizarParcela = false;
    var atualizarTroco = null;
    var salvar = false;
    var recalcularParcelas = null;
    var elementoParcela = null;
    var elementoParcelaCampo = null;    

    publico.init = function(){
        inicializarEventos();
    }
    
    var obterValorTotal = function(){
        var url = "/notafiscal/obtervalortotal";
        $.get(url, function(data){
            $("input[name='valortotal']").val($.toMoney(data));
            atualizarGridParcela();
        });
    }

    var permiteAtualizarGridParcela = function(){
        return !alterarVenda || permiteAtualizarParcela;
    }

    var setarPermiteAtualizarParcela = function(){
        permiteAtualizarParcela = true;
    }

    var atualizarGridParcela = function(){
        var gridParcela = gridElementoParcela.DataTable();

        clearTimeout(carregarGridParcela);
        carregarGridParcela = null;

        if(permiteAtualizarGridParcela()){
            carregarGridParcela = setTimeout(function() {
                gridParcela.ajax.reload();
                calcularDiferencaParcelas();
            }, 500);
        }
    }

    var minimizarEBloquearMenuLateral = function(){
        $("body").addClass("sidebar-collapse");
        $("body").removeClass("fixed");
    } 

    var inicializarEventosVendaItem = function(){
        var gridItem = $('#griditem tbody');
        gridElemento.on('xhr.dt', obterValorTotal);
        gridItem.on("click", "a.btn-warning", alterarItemOnClick);
        gridItem.on( 'click', 'a.btn-danger', deletarItemOnClick);
        modalNotaFiscalItem.on('hidden.bs.modal', modalHidden);
        modalNotaFiscalItem.on('shown.bs.modal', modelShow);
        formNotaFiscalItem.submit(salvarOnClickVendaItem);
        $("#idpessoa").on("change", pessoaOnChange);
        gridElementoParcela.on('draw.dt', inicializarEventosParcela);
        $("#formPrincipal").on('submit', sobreCargaSubmit);
        inicializarAtalhos();
        inicializarEventoAoAlterar();
    }

    var inicializarAtalhos = function(){
        shortcut.add("F4", function (e) {
            $("#idpessoa").selectOpen();
            $("input[type='search']").focus();
        });   
    }

    var inicializarEventoAoAlterar = function(){
        if($.FormularioAlterar()){
            calcularDiferencaParcelas();
        }
    }

    var verificarSalvarPorTipoDeEmpresa = function(){
        if($("#isEmpresaFrigorifico").val() > 0 && $("#griditemparcela").DataTable().data().length == 0)
            salvar = true;
    }

    var sobreCargaSubmit = function(e){
        verificarSalvarPorTipoDeEmpresa();
        if(!salvar){
            e.preventDefault();
            e.stopImmediatePropagation();

            setTimeout(function(){
                var url = "/notafiscal/obtervalortotalparcela";
                $.get(url, function(data){
                    salvar = data == 0;
                    if(!salvar){
                        swal("Existe diferencia entre as parcelas e o valor total do pedido");
                        $.removeLoading();
                        $("#btnSalvar").text("Salvar").removeAttr("disabled");
                    }else
                        $('#formPrincipal').submit();
                });
            }, 400);
        }
    }

    var pessoaOnChange = function(){
        var id = $("#idpessoa").val();
        var url = "/notafiscal/obterdiasemanapessoa";
        var parametro = {id : id};
        $.get(url, parametro, function(data){
            if(data && data[0] != null && data[0].descricao != null){
                $("#alertaFormaRecebimentoCliente").show();
                $("#diaSemanaDescricao").text(data[0].descricao);
            }else
                $("#alertaFormaRecebimentoCliente").hide();
        });
    }

    var inicializarEventos = function(){
        minimizarEBloquearMenuLateral();
        inicializarEventosVendaItem();
        inicializarEventosFormaRecebimento();
        inicializarEventosClickPadrao();


        shortcut.add("F8", function (e){
            setarPermiteAtualizarParcela();
            atualizarGridParcela();
        });

    }

    var inicializarEventosClickPadrao = function(){
        shortcut.add("F1", atalhoParaInserirItem);
        $("#btnInserirObservacaoCliente").on("click", inserirObservacaoClienteOnClick);
        $("#btnInserirCliente").on("click", inserirClienteOnClick);
        $("#btnAtalhos").on("click", btnAtalhosOnClick);
    }

    var calcularDiferencaParcelas = function(){
        var url = "/notafiscal/calculardiferencaparcelas";

        $.get(url, function(data){
            $("input[name='valortotalparcela']").val($.toMoneyVenda(data.valortotalparcela));
            $("input[name='diferencia']").val($.toMoneyVenda(data.diferencia));
        });
    }

    var inicializarEventosFormaRecebimento = function(){
        var idFormaRecebimento = $("select[name='idformarecebimento']");
        idFormaRecebimento.on("change", formaRecebimentoOnChange);
        idFormaRecebimento.trigger("change");
        idFormaRecebimentoItem.on("change", formaRecebimentoItemOnChange);
        idFormaRecebimentoItem.on("select2:select", formaRecebimentoItemOnSelect);
    }

    var formaRecebimentoItemOnSelect = function(){
        setarPermiteAtualizarParcela();
    }

    var btnAtalhosOnClick = function(){
        swal({
            title: "TECLAS QUENTES!",
            text: "INSERIR ITEM <span style='color:#F8BB86'>F1</span>.<br><br> "
            + "SALVAR <span style='color:#F8BB86'>ENTER</span>.<br> ",
            html: true
        });
    }

    var inserirClienteOnClick = function(){
        sweetAlert("Em desenvolvimento", "Disponível em breve");
    }

    var inserirObservacaoClienteOnClick = function(e){
        e.preventDefault();
        var observacao = $("textarea[name='observacao'");
        var cliente = $("#idpessoa").siblings().find(".select2-selection").text();
        if(cliente != undefined && cliente != "")
            observacao.text(observacao.text() + " - [CLIENTE: " + cliente + "]");
    }

    var atalhoParaInserirItem = function (e) {
        e.preventDefault();
        $("#inserirItemVenda").trigger("click");
    }

    var formaRecebimentoItemOnChange = function(){
        if((!$.FormularioAlterar() || $("input[name='valortotalparcela']").val() == "0") || carregarGridParcelaAlterar > 1){
            permiteAtualizarParcela = true;
            var url = "/notafiscal/formarecebimentoitemgerarparcelas";
            var parametro = { idformarecebimentoitem: $(this).val(), idformarecebimento : $("select[name='idformarecebimento']").val() };
            
            $.get(url, parametro, function(data){
                atualizarGridParcela();
            });
        }

        carregarGridParcelaAlterar++;
    }

    var formaRecebimentoOnChange = function(){
        var id = $(this).val();
        if($.isNotNullAndNotEmpty(id)){
            var url = "/notafiscal/obterformarecebimentoitem";
            var parametro = { idformarecebimento: $(this).val() };
            $.get(url, parametro, function(data){
                setarComboFinanceiroItem(data);
                setTimeout(function(){ idFormaRecebimentoItem.trigger("change")}, 200);
            });
        }else
            idFormaRecebimentoItem.empty()
    }

    var setarComboFinanceiroItem = function(data){
        idFormaRecebimentoItem.empty()
        
        idFormaRecebimentoItem.select2({
            data: data
        });

        var idFormaRecebimentoItemHidden = $("#idformarecebimentoitemhidden").val();
        if($.isNotNullAndNotEmpty(idFormaRecebimentoItemHidden)){
            if(data != null){
                var elemento = $.firstOrDefaultId(data, idFormaRecebimentoItemHidden);
                idFormaRecebimentoItem.select2('destroy').empty().select2({data: [elemento]});
                $("#idformarecebimentoitemhidden").val("");
            }
        }
    }

    var salvarOnClickVendaItem = function (e){
        produto = $("#itemNotaFiscalModal #idproduto").val();

        if($.isNotNullAndNotEmpty(produto)){
            var grid = $('#griditem').DataTable();
            var viewModel = $(this).serialize();
            var urlAlterarInserir = (alterar ? "alterar" : "inserir") + "notafiscalitem";
            var url = "/notafiscal/" + urlAlterarInserir;

            $.post(url, viewModel, function(data){
                setarPermiteAtualizarParcela();
                grid.ajax.reload();
                modalNotaFiscalItem.modal('hide');
            }).fail(function(data){
                console.log(data);
            });
        }

        e.preventDefault();
    }

    var alterarItemOnClick = function(){
        var grid = gridElemento.DataTable();
        var row = grid.row($(this).parents('tr'));
        var data = row.data();
        alterar = true;

        if (data != null) {
            var url = "/notafiscal/alterarnotafiscalitem";
            var parametro = {'id' : data.id};
            $.get(url, parametro, function(data){
                formNotaFiscalItem.find(".modal-body").html(data);
                modalNotaFiscalItem.modal('show');
            });
        }else
            sweetAlert("Alerta!", "Selecione um registro", "error");
    }

    var deletarItemOnClick = function(){
        var grid = gridElemento.DataTable();
        var row = grid.row($(this).parents('tr'));
        var data = row.data();

        if(data != null){
            var url = "/notafiscal/deletarvendaitem";
            var parametro = {'id' : data.id};
            $.post(url, parametro, function(){ grid.ajax.reload(); });
        }else
            sweetAlert("Alerta!", "Selecione um registro", "error");
    }

    var modelShow = function () {
        if(!alterar){
            var box = $("#boxLancamento");
            box.startLoad()
            box.removeLoad();
            var url = "/notafiscal/inserirnotafiscalitem";
            $.get(url, function(data){
                formNotaFiscalItem.find(".modal-body").html(data);
            });
        }
    }

    var modalHidden = function(){
        alterar = false;
        $(this).find("input:text, textarea, select").val('').end();
        $(this).find(".flat-red").iCheck('check'); 
        $(this).find(".callout").html("");
        $(this).find(".callout").hide();
    }

    /* EVENTOS PARCELAS */
    var inicializarEventosParcela = function(){
        $(".valorparcela").on("change", recarregarTroco);
        $(".valorparcela").on("keypress", recarregarTroco);
        $(".parcela_datavencimento").on("keypress", recarregarParcela);        
        $(".parcela_datavencimento").on("change", recarregarParcela);  
        $(".especietipo").on("keypress", recarregarTipoEspecie);        
        $(".especietipo").on("change", recarregarTipoEspecie);  
    }

    var selecionarPrimeiroValorParcela = function(){
        var valorParcelaElemento = $(".valorparcela");
        if(valorParcelaElemento.length > 0){
            var primeiroValorParcela = valorParcelaElemento[0];
            if(primeiroValorParcela.length > 0)
                primeiroValorParcela.focus().select();
        }
    }

    var recarregarParcela = function(e, that){
        var grid = $("#griditemparcela").DataTable();
        if(that == null || that == undefined)
            that = $(this);

        var url = "/venda/alterarparcelaparcela";
        var id = that.attr("id");
        var row = grid.row($("#" + id).closest('tr'));
        var item = row.data();
        item['datavencimento'] = that.val();
        $.post(url, item);
    }

    var recarregarTipoEspecie = function(e, that){
        var grid = $("#griditemparcela").DataTable();
        
        if(that == null || that == undefined)
            that = $(this);

        var url = "/venda/alterarparcelaespecie";
        var id = that.attr("id");
        var row = grid.row($("#" + id).closest('tr'));
        var item = row.data();
        item['idfinanceirotipo'] = that.val();
        $.post(url, item);
    }

    var recarregarTrocoInterno = function(){
        var e = elementoParcela;
        var that = elementoParcelaCampo; 

        if(that == null || that == undefined)
            that = $(e.currentTarget);

        var gridParcela = $("#griditemparcela").DataTable();
        var gridItens = gridParcela.rows().data();
        var retorno = [];
        var id = that.attr('id');

        for(i = 0; i < gridItens.length; i++){
            var item = gridItens[i];
            if(item.id == id)
                item.valor = that.val();
            retorno[i] = item;
        }

        
        var url = "/notafiscal/alterarparcelasvalores";
        var parametro = {"item" : obterDataItem(id), "itens" : JSON.stringify(retorno)};
        $.post(url,  parametro, function(data){
            setarValorRecebidoParcela();
            calcularDiferencaParcelas();
        });
    }

    var obterDataItem = function(id){
        return $("#griditemparcela").DataTable().row($("#" + id).closest('tr')).data();
    }

    var recarregarTroco = function(e, that){
        clearTimeout(recalcularParcelas);
        elementoParcela = e;
        elementoParcelaCampo = that;    
        recalcularParcelas = setTimeout(recarregarTrocoInterno, 1000);
    }

    var setarValorRecebidoParcela = function(){
        setTimeout(function(){
            var gridParcela = gridElementoParcela.DataTable();
            gridParcela.ajax.reload();
        }, 120);
    }

    /* FIM ENVETOS PARCELAS */

    publico.formatarDescricao = function(dados){
        return dados.descricao + "<br>  "
        +  ('<span class="label label-danger"> DESC ' + $.fn.dataTable.render.number('.', ',', 2, "R$").display(dados.descontomoeda) + (dados.descontoporcentagem != null ? (' | ' + dados.descontoporcentagem.replace(".", ",") + '%') : '') +'</span>')
        + '  ' +  ('<span class="label label-success"> ACRES ' + $.fn.dataTable.render.number('.', ',', 2, "R$").display(dados.acrescimomoeda) + '</span>');
    }

    return publico;
});

$(function() {
    $.namespace('updatenotafiscalutilitario').init();
});