$.namespace('updatevenda', function(){
    var publico = {};
    var produto = $("#idproduto");
    var formVendaItem = $("#form-item");
    var gridElemento = $('#griditem');
    var permiteAtualizarParcela = false;
    var idFormaRecebimentoItem = $("select[name='idformarecebimentoitem']");
    var gridElementoParcela = $("#griditemparcela");
    var carregarGridParcela = null;
    var alterarVenda = $("#action").val() == "alterar";
    var atualizarTroco = null;
    var salvar = false;
    var alterarFormaRecebimentoPelaPrimeiraVez = true;

    publico.init = function(){
        inicializarEventos();
    }

    var minimizarEBloquearMenuLateral = function(){
        $("body").addClass("sidebar-collapse");
        $(".sidebar-toggle").hide();
    } 

    var inicializarEventos = function(){
         var gridItem = $('#griditem tbody');
        iniciarlizarGridItem();
        minimizarEBloquearMenuLateral();
        updatetemplatejs.comboBoxSelect("idproduto", "/venda/obterproduto");
        inicializarAtalhos();
        inicializarEventosProduto();
        mensagemAlerta();
        gridItem.on('click', 'a.btn-danger', deletarItemOnClick);
        inicializarEventosFormaRecebimento();
    }

    var inicializarAtalhos = function(){
        shortcut.add("F1", function (e) {
            produtoOnFocus();
        });

        shortcut.add("pageup", function (e) {
            alterarQuantidade();
        });

        shortcut.add("pagedown", function (e) {
            alterarQuantidade(true);
        });

        shortcut.add("insert", function (e) {
            eventoAposInserirProduto();
        });        

        shortcut.add("F9", function (e) {
            $("input[name='faturar']").val("0");
            salvarOnClick();
        });     

        shortcut.add("F10", function (e){
            fecharOnClick();
        });    

        shortcut.add("F6", function (e){
            $("#itemObservacao").modal('show');
        });

        shortcut.add("F7", function (e){
            $("#itemDataVenda").modal('show');
        });

        shortcut.add("F8", function (e) {
            recarregarTrocosTodos();
        });   

        shortcut.add("F4", function (e) {
            $("#idpessoa").selectOpen();
            $("input[type='search']").focus();
        });   

        $("#btnObservacao").on("click", function(){
            $("#itemObservacao").modal('show');

            setTimeout(function(){
                $("#observacao").focus().select();
            }, 100);
        });

        shortcut.add("END", function (e) {
            if($("#griditemparcela").DataTable().data().length > 0){
                $("input[name='faturar']").val("1");
                salvarOnClick();
            }
        });   

        $("#btnCancelar").on("click", function(e){
            updatetemplatejs.atalhoCancelar(e);
        });

        $("#btnDataVenda").on("click", function(){
            $("#itemDataVenda").modal('show');
            $("input[name='datavenda']").focus();
        });

        $("#salvarFormaRecebimento").on('click', function(){
            if($("#griditemparcela").DataTable().data().length > 0){
                $("input[name='faturar']").val("1");
                salvarOnClick();
            }
        });
        
        gridElementoParcela.on('draw.dt', inicializarEventosParcela);
        $("#btnInserir").on("click", eventoAposInserirProduto);
        $("#btnFechar").on("click", fecharOnClick);

        $("#formPrincipal").on('submit', function(e){
            $.limparBloqueioSairDaTela();
            if(!salvar){
                e.preventDefault();
                e.stopImmediatePropagation();

                setTimeout(function(){
                    var url = "/vendasimples/obtervalortotalparcela";
                    $.get(url, function(data){
                        debugger;
                        salvar = data == 0 || data < 0;
                        if(!salvar){
                            swal("Existe diferencia entre as parcelas e o valor total do pedido");
                            $.removeLoading();
                            $("#btnSalvar").text("Salvar").removeAttr("disabled");
                        }else
                            $('#formPrincipal').submit();
                    });
                }, 400);
            }
        });
    }

    var inicializarEventosParcela = function(){
        if($(".valorparcela").length > 0)
            $(".valorparcela")[0].focus();
        $(".valorparcela").on("change", recarregarTroco);
        $(".valorparcela").on("keypress", carregarTrocoKeyPress);
        $(".parcela_datavencimento").on("keypress", carregarTrocoKeyPress);        
        $(".parcela_datavencimento").on("change", carregarTrocoKeyPress);  
        $(".especietipo").on("keypress", carregarTrocoKeyPress);        
        $(".especietipo").on("change", carregarTrocoKeyPress);  
    }

    var selecionarPrimeiroValorParcela = function(){
        var valorParcelaElemento = $(".valorparcela");
        if(valorParcelaElemento.length > 0){
            var primeiroValorParcela = valorParcelaElemento[0];
            if(primeiroValorParcela.length > 0)
                primeiroValorParcela.focus().select();
        }
    }

    var carregarTrocoKeyPress = function(e){
        clearTimeout(atualizarTroco);
        atualizarTroco = null;

        atualizarTroco = setTimeout(function() {
            recarregarTrocosTodos();
        }, 500);
    }

    var recarregarTrocosTodos = function(e){
        if($(".valorparcela").length > 0){
            $.each($(".valorparcela"), function(index, elemento){
                recarregarTroco(e, $(elemento));
            });
        }
    }

    var recarregarTroco = function(e, that){
        if($(".valorparcela").length > 0){
            calcularDiferencaParcelas();
            var grid = $("#griditemparcela").DataTable();
            if(that == null || that == undefined)
                that = $(this);

            var row = grid.row($("#" + that.attr('id')).closest('tr'));
            var item = row.data();

            if($.isNotNullAndNotEmpty(that.val()) && $.isNotNullAndNotEmpty(item)){
                item['valor'] = that.val();
                var url = "/venda/alterarvalorparcela";
                var parametro = item;
                $.post(url, parametro, function(data){
                    setarValorRecebidoParcela();
                });
            }
        }
    }

    var calcularDiferencaParcelas = function(){
        var url = "/vendasimples/calculardiferencaparcelas";

        $.get(url, function(data){
            $("input[name='valortotalparcela']").val($.toMoneyVenda(data.valortotalparcela));
            $("input[name='diferencia']").val($.toMoneyVenda(data.diferencia));
        });
    }

    var gridPreenchida = function(){
         var grid = gridElemento.DataTable();
         return grid.data().length > 0; 
    }

    var salvarOnClick = function(){
        if(gridPreenchida()){
            $("#formPrincipal").submit();
        }else{
            iziToast.error({
                title: 'Atenção',
                message: 'É NECESSARIO INSERIR UM ITEM PARA SALVAR A VENDA',
            });
        }
    }

    // var inserirProdutoAoFechar = function(){
    //     var produto = $("#idproduto").val();
    //     if($.isNotNullAndNotEmpty(produto)){
    //         eventoAposInserirProduto();
    //     }
    // }

    var fecharOnClick = function(){
        //inserirProdutoAoFechar();
 
        if(gridPreenchida()){
            setarPermiteAtualizarParcela();
            atualizarGridParcela();
            produto.select2("close");
            setarValorRecebidoParcela();
            $('#itemFormaRecebimento').modal('show');
        }else{
            iziToast.error({
                title: 'Atenção',
                message: 'É NECESSARIO INSERIR UM ITEM PARA FECHAR A VENDA',
            });
        }
    }

    var setarValorRecebidoParcela = function(){
        setTimeout(function(){
            var gridParcela = gridElementoParcela.DataTable();
            gridParcela.ajax.reload();
            calcularDiferencaParcelas();
            
            var url = "/venda/obtervalortotalparcelas";
            $.get(url, function(data){
                var valorpacela = $.fn.dataTable.render.number('.', ',', 2, "R$").display(data['valorpacela']);
                var troco = $.fn.dataTable.render.number('.', ',', 2, "R$").display(data['troco']);
                var valorareceber = $.fn.dataTable.render.number('.', ',', 2, "R$").display(data['valorareceber']);
                $("input[name='valorrecebido']").val(valorpacela);
                $("input[name='valortroco']").val(troco);
                $("input[name='valorareceber']").val(valorareceber);            
            });
        }, 120);
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

    var alterarQuantidade = function(pagdown){
        var input_quantidade = $("input[name='quantidade']");
        var quantidade = input_quantidade.val();

        if(quantidade == 0) input_quantidade.val("1");
        else{
            pagdown ? quantidade-- : quantidade++;
            input_quantidade.val(quantidade);

            if(quantidade == 0) input_quantidade.val("1");
        }
    }

    var mensagemAlerta = function(){
        iziToast.warning({
            title: 'Atalho',
            message: 'Utilize F11, para ter uma melhor experiência com a tela cheia'
        });
    }

    var inserirItem = function(){
         var grid = gridElemento.DataTable();
         var url = "/venda/inserirvendaitem";
         var parametro = {
             'idproduto' : produto.val(),
             'descricao' : $("#select2-idproduto-container").text(),
             'quantidade' : $("input[name='quantidade']").val(),
             'descontomoeda' : $("input[name='descontomoeda']").val(),
             'acrescimomoeda' : $("input[name='acrescimomoeda']").val(),
             'valorunitario' : 100
         };

         $.post(url, parametro, (data) => {
             grid.ajax.reload();
         });
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

    var permiteAtualizarGridParcela = function(){
        return permiteAtualizarParcela;
    }

    var inicializarEventosFormaRecebimento = function(){
        var idFormaRecebimento = $("select[name='idformarecebimento']");
        idFormaRecebimento.on("change", formaRecebimentoOnChange);
        idFormaRecebimento.trigger("change");
        idFormaRecebimentoItem.on("change", formaRecebimentoItemOnChange);
        idFormaRecebimentoItem.on("select2:select", formaRecebimentoItemOnSelect);
    }

    var setarPermiteAtualizarParcela = function(){
        permiteAtualizarParcela = true;
    }

    var formaRecebimentoItemOnSelect = function(){
        setarPermiteAtualizarParcela();
    }

    var formaRecebimentoOnChange = function(){
        var id = $(this).val();
        if($.isNotNullAndNotEmpty(id)){
            var url = "/vendasimples/obterformarecebimentoitem";
            var parametro = { idformarecebimento: $(this).val() };
            $.get(url, parametro, function(data){
                idFormaRecebimentoItem.empty()
                setarComboFinanceiroItem(data);
                setTimeout(function(){ idFormaRecebimentoItem.trigger("change")}, 200);
            });
        }else
            idFormaRecebimentoItem.empty()
    }

    var setarComboFinanceiroItem = function(data){
        idFormaRecebimentoItem.select2({
            data: data
        });

        var idFormaRecebimentoItemHidden = $("#idformarecebimentoitemhidden").val();

        if($.isNotNullAndNotEmpty(idFormaRecebimentoItemHidden)){
            var elemento = $.firstOrDefaultId(data, idFormaRecebimentoItemHidden);
            idFormaRecebimentoItem.select2().select2('val', elemento.text);
        }
    }

    var inicializarEventosProduto = function(){
        produto.on("select2:select", produtoOnSelect);
    }

    var produtoOnSelect = function(e){
        $("input[name='quantidade']").focus().select();
    }

    var mensagemProdutoInserido = function(){
        inserirItem();
        var descricao = $("#select2-idproduto-container").text();
        iziToast.success({
            title: 'OK',
            message: 'PRODUTO:' + descricao + " QUANTIDADE: "+ $("input[name='quantidade']").val(),
        });
    }

    var atualizarCalculos = function(){
        obterValorTotal();
    }

    var obterValorTotal = function(){
        var url = "/venda/obtervalores";
        $.get(url, (data) => {
            $("#totalItens").text(data['quantidadeItens']);
            $(".valorItens").text($.fn.dataTable.render.number('.', ',', 2, "R$").display(data['valortotal']));
            $(".totalPagar").text($.fn.dataTable.render.number('.', ',', 2, "R$").display(data['valortotalpagar']));

            $("#spanDesconto").text($.fn.dataTable.render.number('.', ',', 2, "R$").display(data['descontomoeda']));
            $("#spanAcrescimo").text($.fn.dataTable.render.number('.', ',', 2, "R$").display(data['acrescimomoeda']));
        });
    }

    var formaRecebimentoItemOnChange = function(){
        setTimeout(function() {
            var url = "/vendasimples/formarecebimentoitemgerarparcelas";
            var parametro = { idformarecebimentoitem: $("select[name='idformarecebimentoitem']").val(), idformarecebimento : $("select[name='idformarecebimento']").val() };
            $.get(url, parametro, function(data){
                atualizarGridParcela();
            });
        }, 350);
    }

    var eventoAposInserirProduto = function (e){
        if($.isNotNullAndNotEmpty($("#idproduto").val()) && $.isNotNullAndNotEmpty($("input[name='quantidade']").val())){
            mensagemProdutoInserido();
            produto.empty().trigger('change');
            $("input[name='quantidade']").val("1");
            $("#descontomoeda").val(0);
            $("#acrescimomoeda").val(0);
            formaRecebimentoItemOnChange();
            produtoOnFocus();
            atualizarCalculos();
            atualizarGridParcela();
        }else{
            iziToast.error({
                title: 'Atenção',
                message: 'SELECIONE O PRODUTO E A QUANTIDADE PARA INSERIR',
            });
        }
    }

    var gridItemEventoRecarregar = function(){
        atualizarCalculos();
    }

    var produtoOnFocus = function(){
        produto.selectOpen();
        $("input[type='search']").focus();
    }


    var iniciarlizarGridItem = function(){
        gridElemento.on('xhr.dt', gridItemEventoRecarregar);

        gridElemento.DataTable( {
                "bFilter": false,
                "paging": false,
                "info": false,
                "scrollY": "380px",
                "scrollCollapse": true,
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
                    "url": "/venda/obteritens",
                    "dataSrc": ""
                },
                "columnDefs": [ {
                        "targets": -1,
                        "data": null,
                        "defaultContent": ""
                } ],
                "columns": [
                    { "data": "id" },
                    { "data": "descricao" },
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
                            return '<a class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
                        }
                    },
                ]
            } );
    }

    return publico;
});

$(function() {
    $.namespace('updatevenda').init();
    $.bloquearSairDaTela();
});