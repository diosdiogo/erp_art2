<?php

namespace App\Enums;

abstract class FinanceiroLancamentoTipoEnum
{
    const PAGAMENTO = 1;
    const RECEBIMENTO = 2;
    const TRANSFERENCIA = 3;
    const CONTAPAGAR = 4;
    const CONTARECEBER = 5;
}