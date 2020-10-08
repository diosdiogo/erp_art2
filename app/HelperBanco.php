<?php

namespace App;

use Session;

class HelperBanco
{
    public static function conexao(){
        return Session::get('usuario_banco');
    }
}
