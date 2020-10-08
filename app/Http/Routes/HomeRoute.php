<?php

namespace App\Http\Routes;

use Route;

class HomeRoute 
{
    public static function rotas(){
        Route::auth();
        Route::controller('home', 'HomeController');
        Route::controller('empresa', 'Sistema\Empresa\EmpresaController');
        Route::controller('notificacao', 'Sistema\Notificacao\NotificacaoController');
        Route::controller('transportadora', 'Sistema\Transportadora\TransportadoraController');
        Route::controller('documentacao', 'Sistema\Documentacao\DocumentacaoController');
        Route::controller('minhaconta', 'Sistema\Minhaconta\MinhaContaController');
    } 
}

