 $.namespace("updateempresa", function(){
    var publico = {};

   
    publico.init = function () {
        updatetemplatejs.comboBoxSelect("idcidade", "/empresa/obtercidade");
        updatetemplatejs.comboBoxSelect("idcnae", "/empresa/obtercnae");
        updatetemplatejs.comboBoxSelect("idfiscalcfopdentroestado", "/empresa/obtercfop");
        updatetemplatejs.comboBoxSelect("idfiscalcfopforaestado", "/empresa/obtercfop");
        setTimeout(function(){ $(".textarea").wysihtml5(); }, 100);
        tratarImagem();
        inicializarExemplo();
    };

    var inicializarExemplo = function(){
        $("#btnExemplo").on("click", exemploOnClick);
    }

    var exemploOnClick = function(){
        $("#exemploRelatorio").modal('show');
    }

    var tratarImagem = function(){
        var inputs = document.querySelectorAll( '.inputfile' );
        Array.prototype.forEach.call( inputs, function( input )
        {
            var label	 = input.nextElementSibling,
            labelVal = label.innerHTML;

                input.addEventListener( 'change', function( e )
                {
                    var fileName = '';
                    if( this.files && this.files.length > 1 )
                        fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
                    else
                        fileName = e.target.value.split( '\\' ).pop();

                    if( fileName )
                        label.querySelector( 'span' ).innerHTML = fileName.toUpperCase();
                    else
                        label.innerHTML = labelVal;
                });

                input.addEventListener( 'focus', function(){ input.classList.add( 'has-focus' ); });
                input.addEventListener( 'blur', function(){ input.classList.remove( 'has-focus' ); });
        });
    }

    return publico;
});

$(function(){
    $.namespace("updateempresa").init();
});