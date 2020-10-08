<?php

namespace App\Models\Sistema\Endereco;

use App\Models\BaseModelSistema;
use App\Models\Sistema\Endereco\Estado;

class Cidade extends BaseModelSistema
{
    public function estado(){
        return $this->belongsTo(Estado::class, 'idestado');
    }
}
