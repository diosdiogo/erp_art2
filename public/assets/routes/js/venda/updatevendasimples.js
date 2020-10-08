$.namespace('updatevendasimples', function(){
    var publico = {};
    var gridElemento = $('#griditem');
    var gridElementoParcela = $("#griditemparcela");
    var alterar = false;
    var modalVendaItem = $('#itemVendaModal');
    var carregarGridParcela = null;
    var carregarGridParcelaAlterar = 0;
    var idFormaRecebimentoItem = $("select[name='idformarecebimentoitem']");
    var formVendaItem = $("#form-item");
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
        var url = "/vendasimples/obtervalortotal";
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
        modalVendaItem.on('hidden.bs.modal', modalHidden);
        modalVendaItem.on('shown.bs.modal', modelShow);
        formVendaItem.submit(salvarOnClickVendaItem);
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

        shortcut.add("F6", function (e) {
            $("#idformarecebimento").selectOpen();
            $("input[type='search']").focus();
        });

        shortcut.add("F7", function (e) {
            idFormaRecebimentoItem.selectOpen();
            $("input[type='search']").focus();
        });

        shortcut.add("F9", function (e) {
            $("input[name='faturar']").val("0");
            $("#formPrincipal").submit();
        });

        shortcut.add("F10", function (e) {
            $("input[name='faturar']").val("1");
            $("#formPrincipal").submit();
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
        $.limparBloqueioSairDaTela();
        verificarSalvarPorTipoDeEmpresa();
        if(!salvar){
            e.preventDefault();
            e.stopImmediatePropagation();

            setTimeout(function(){
                var url = "/vendasimples/obtervalortotalparcela";
                $.get(url, function(data){
                    salvar = data == 0;
                    if (!salvar) {
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
        var url = "/vendasimples/obterdiasemanapessoa";
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
        var url = "/vendasimples/calculardiferencaparcelas";

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
            text: "PESSOA <span style='color:RED'><b>F4</b></span>.<br><br> "
            + "INSERIR ITEM <span style='color:RED'><b>F1</b></span>.<br><br>"
            + "FORMA RECEBIMENTO <span style='color:RED'><b>F6</b></span>.<br><br>"
            + "FORMA RECEBIMENTO ITEM <span style='color:RED'><b>F7</b></span>.<br><br>"
            + "SALVAR <span style='color:RED'><b>F9</b></span>.<br><br>"
            + "FECHAR <span style='color:RED'><b>F10</b></span>.<br> ",
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
        if ((!$.FormularioAlterar() || $("input[name='valortotalparcela']").val() == "0") || (carregarGridParcelaAlterar > 1 || $("input[name='idformarecebimentoitemhidden']").attr('value') != $(this).val())) {
            permiteAtualizarParcela = true;
            var url = "/vendasimples/formarecebimentoitemgerarparcelas";
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
            var url = "/vendasimples/obterformarecebimentoitem";
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
        produto = $("#form-item #idproduto").val();

        if($.isNotNullAndNotEmpty(produto)){
            var grid = $('#griditem').DataTable();
            var viewModel = $(this).serialize();
            var urlAlterarInserir = (alterar ? "alterar" : "inserir") + "vendaitem";
            var url = "/vendasimples/" + urlAlterarInserir;

            $.post(url, viewModel, function(data){
                setarPermiteAtualizarParcela();
                grid.ajax.reload();
                modalVendaItem.modal('hide');
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

        if(data != null){
            var url = "/vendasimples/alterarvendaitem";
            var parametro = {'id' : data.id};
            $.get(url, parametro, function(data){
                formVendaItem.find(".modal-body").html(data);
                modalVendaItem.modal('show');
            });
        }else
            sweetAlert("Alerta!", "Selecione um registro", "error");
    }

    var deletarItemOnClick = function(){
        var grid = gridElemento.DataTable();
        var row = grid.row($(this).parents('tr'));
        var data = row.data();

        if(data != null){
            var url = "/vendasimples/deletarvendaitem";
            var parametro = {'id' : data.id};
            $.post(url, parametro, function(){ grid.ajax.reload(); });
        }else
            sweetAlert("Alerta!", "Selecione um registro", "error");
    }

    var modelShow = function(){
        if(!alterar){
            var box = $("#boxLancamento");
            box.startLoad()
            box.removeLoad();
            var url = "/vendasimples/inserirvendaitem";
            $.get(url, function(data){
                formVendaItem.find(".modal-body").html(data);
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
        item['evento'] = that.attr('id');
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

        
        var url = "/vendasimples/alterarparcelasvalores";
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

    gridElemento.DataTable( {
        "bFilter": true,
        "paging": true,
        "info": true,
        "pagingType": "full_numbers",
          "language": {
                "sEmptyTable": "Nenhum registro encontrado",
                "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                "sInfoPostFix": "",
                "sInfoThousands": ".",
                "sLengthMenu": "_MENU_ resultados por página",
                "sLoadingRecords": "Carregando...",
                "sProcessing": "Processando...",
                "sZeroRecords": "Nenhum registro encontrado",
                "sSearch": "Pesquisar",
                "oPaginate": {
                    "sNext": "Próximo",
                    "sPrevious": "Anterior",
                    "sFirst": "Primeiro",
                    "sLast": "Último"
                },
                "oAria": {
                    "sSortAscending": ": Ordenar colunas de forma ascendente",
                    "sSortDescending": ": Ordenar colunas de forma descendente"
                }
    },
        "ajax": {
            "url": "/vendasimples/obteritens",
            "dataSrc": ""
        },
        "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": ""
        } ],
        "columns": [
            { "data": "id" },
            {
                    sortable: false,
                    "render": function ( data, type, dados, meta ) {
                    return updatevendasimples.formatarDescricao(dados);
                }
            },
            { "data": "quantidade" },
            {
                data: "valorunitario",
                sortable: false,
                render: function ( data, type, full, meta ) {
                    return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                }
            },
            {
                data: "valortotal",
                sortable: false,
                render: function ( data, type, full, meta ) {
                    return $.fn.dataTable.render.number('.', ',', 2, "R$").display(data);
                }
            },
            {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                    var buttonID = "withdraw_"+full.id;
                    return '<a class="btn btn-xs btn-warning"><i class="fa fa-edit"></i></a>  <a class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
                }
            },
        ]
    } );

    return publico;
});

$(function() {
    $.namespace('updatevendasimples').init();
    $.bloquearSairDaTela();
});

