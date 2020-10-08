<?php

namespace App\Http\Routes;

use Route;

class ProducaoRoute 
{
    public static function rotas(){
        Route::controller('producaomaquina', 'Sistema\Producao\Maquina\ProducaoMaquinaController');
        Route::controller('producaocontrole', 'Sistema\Producao\Controle\ProducaoControleController');        
    } 
}
