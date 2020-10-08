<?php

namespace App\Extension;

class MapperExtension
{
    public static function mapear($arrayAntigo, $arrayNovo){
        if(is_array($arrayNovo))
            return array_merge($arrayAntigo, $arrayNovo);

        return $arrayAntigo;
    }
}