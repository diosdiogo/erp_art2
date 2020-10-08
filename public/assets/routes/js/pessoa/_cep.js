$.namespace("_cep", function(){
    var publico = {};
    var rua = $("input[name='endereco']");
    var bairro = $("input[name='bairro']");
    var cidade = $("#idcidade");


    function limpa_formulário_cep() {
        rua.val("");
        bairro.val("");
        cidade.val("");
    }

    var cepOnClick = function () {
        var cep = $(this).val().replace(/\D/g, '');

          if (cep != "") {

            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {

                rua.val("...");
                bairro.val("...");
                cidade.val("...");
                
                var url = "//viacep.com.br/ws/"+ cep +"/json/?callback=?";
                $.getJSON(url, function (dados) {
                    if (!("erro" in dados)) {
                        rua.val(dados.logradouro);
                        bairro.val(dados.bairro);
                        setarCidade(dados.ibge);
                    }
                    else {
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            }
            else {
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        }
        else
            limpa_formulário_cep();
    }

    var setarCidade = function(codigoIBGE){
        var url = "/empresa/obterdescricaocidade";
        var parametro = {parametro: codigoIBGE};
        $.get(url, parametro, function(item){
            cidade.select2("trigger", "select", {
                data: item
            });
        });
    }

            

    publico.init = function(){
        $("#cep").blur(cepOnClick);
    }

    return publico;
});

$(function(){
    $.namespace("_cep").init();
});            