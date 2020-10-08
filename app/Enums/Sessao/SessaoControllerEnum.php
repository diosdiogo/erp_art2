<?php
namespace App\Enums\Sessao;

abstract class SessaoControllerEnum
{
    const ConfiguracaoPadrao = "configuracaoPadraoSession";
    const Notificacao = "notificacaoSession";
    const Empresa = "empresaSession";
    const UpdateViewModel = "UpdateViewModelSession";
    const GridViewModel = "GridViewModelSession";
    const IdUsuario = "usuarioId";
    const NaoLimparUpdateViewModel = "NaoLimparUpdateViewModelSession";
    const EmpresaFilial = "usuario_empresafilial";
    const ConcluirEdicao = "concluir_edicao";
    const DataInicial = "data_inicial";
    const DataFinal = "data_final";
}