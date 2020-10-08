<?php

namespace App\Models\Sistema\Parametro\Mercadoria;

use App\Models\BaseModel;

class ParametroMercadoria extends BaseModel
{
    protected $fillable = array('idempresa', 'permitevendacomestoquenegativo', 'usadetalhe');
}