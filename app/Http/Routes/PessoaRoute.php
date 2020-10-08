<?php

namespace App\Http\Routes;

use Route;

class PessoaRoute 
{
    public static function rotas(){
        Route::controller('pessoa', 'Sistema\Pessoa\PessoaController');
        Route::controller('pessoaramoatividade', 'Sistema\Pessoa\RamoAtividade\PessoaRamoAtividadeController');
        Route::controller('usuario', 'Sistema\Usuario\UsuarioController');
    } 
}
