<?php

namespace App\Models\Sistema\Parametro\Faturamento;

use App\Models\BaseModel;

class ParametroFaturamento extends BaseModel
{
    protected $fillable = array('idempresa', 'recalcularformarecebimento');
}