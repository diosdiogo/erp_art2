<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModelSistema extends BaseModel
{
    public function __construct(){
       $this->connection = $this->connection ?: \Session::get('usuario_banco');
    }
}