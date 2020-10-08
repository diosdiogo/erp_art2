<?php

namespace App\Enums\Controller;

abstract class ControllerEnum
{
    const InserirMaiusculo = "Inserir";
    const InserirMinusculo = "inserir";
    const InserirValidarInserir = "validarInserir";
    const InserirAlterarValidarAlias = "validarAlias";
    const InserirMetodoCorrigirRelacionamento = "corrigirRelacionamentoInserir";

    const AlterarMinusculo = "alterar";
    const AlterarMetodoCorrigirRelacionamento = "corrigirRelacionamentoAlterar";
    const AlterarValidarAlterar = "validarAlterar";
    const ValidarAntesDeAlterar = "validarAntesDeAlterar";
    const ValidarAntesDeDeletar = "validarAntesDeDeletar";

    const ObterGrid = "obterGrid";
}