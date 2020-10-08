<?php

namespace App\ViewModel\Sistema\Notificacao;

class UpdateNotificacaoViewModel
{
    public function inserir(){
        return array(
                        'id' => '',
                        'titulo' => '',
                        'texto' => '',
                        'lida' => true
                    );
    }
}
