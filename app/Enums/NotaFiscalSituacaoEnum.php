<?php

namespace App\Enums;

abstract class NotaFiscalSituacaoEnum
{
    const AUTORIZADA = "1";
    const INUTILIZADA = "2";
    const DENEGADA = "3";
    const CANCELADA = "4";
    const ESTORNADA = "5";
    const ENVIAR = "6";
    const REJEICAO = "7";
    const OUTROS = "8";
    const NAOENCONTRADA = "9";
}