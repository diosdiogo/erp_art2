<?php

namespace App\ViewModel\Sistema\Parametro\Mercadoria;

class UpdateParametroMercadoriaViewModel
{
    public function inserir(){
        return array(
            "permitevendacomestoquenegativo" => 'false',
            'usadetalhe' => 'false',
        );
    }

}