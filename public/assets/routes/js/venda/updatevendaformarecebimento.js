$.namespace('updatevendaformarecebimento', function(){
    var publico = {};
    var gridElementoParcela = $("#griditemparcela");

    publico.init = function(){
        inicializarEventos();
    }

    var inicializarEventos = function(){
        
    }

    gridElementoParcela.DataTable( {
        "bFilter": false,
        "paging": false,
        "info": false,
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
            "url": "/vendasimples/obterparcelaitens",
            "dataSrc": ""
        },
        "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": ""
        } ],
        "columns": [
            { "data": "parcela" },
            {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                    var buttonID = "parcela_datavencimento" + full.id;
                    return '<input id="'+ buttonID +'" value="' +  full.datavencimento +'" type="date" class="form-control parcela_datavencimento" />';
                }
            },            
            {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                    var buttonID = "especie_" + full.id;
                    return '<div style="width:130px"><select style="width:250px" id="'+ buttonID +'" class="form-control especietipo">'+
                             '<option value="' + (full.idfinanceirotipo == undefined ? 1 : full.idfinanceirotipo) +' ">'+ (full.financeirotipodescricao == undefined ? "1 - DINHEIRO" : full.financeirotipodescricao) +'</option>' +
                           '</select>'
                    + '<script>updatetemplatejs.comboBoxSelect("'+ buttonID +'", "/vendasimples/obterespecie")</script></div>';
                }
            },
            {
                    sortable: false,
                    "render": function ( data, type, full, meta ) {
                    var buttonID = "parcela_valor" + data.id;
                    return '<input id="'+ full.id +'" value="' + $.toMoneyVendaSimples(full.valor) +'" type="text" class="form-control form money valorparcela" />';
                }
            }
        ]
    } );

    return publico;
});

$(function() {
    $.namespace('updatevendaformarecebimento').init();
});