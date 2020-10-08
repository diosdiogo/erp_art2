<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        /* N�o mudar a ordem */
        $this->call(EmpresaFilialSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(PessoaSexoSeeder::class);
        $this->call(MenuPainelSeeder::class);
        $this->call(EnderecoTipoSeeder::class);
        $this->call(PessoaTipoSeeder::class);
        $this->call(PessoaRelacaoSeeder::class);
        $this->call(PessoaTipoContribuinteSeeder::class);
        $this->call(UFSeeder::class);
        $this->call(ConfiguracaoPadraoSeeder::class);
        $this->call(ParametroFinanceiro::class);
        $this->call(NotificacaoSeeder::class);
        $this->call(UnidadeMedidaSeeder::class);
        $this->call(ProdutoFiscalTipoSeerder::class);
        $this->call(ProdutoFiscalOrigemMercadoriaSeerder::class);
        $this->call(DiaDaSemanaSeeder::class);
        $this->call(NCMSeeder::class);
        $this->call(FinanceiroBancoSeeder::class);
        $this->call(ParametroMercadoriaSeeder::class);
        $this->call(PessoaSeeder::class);
        $this->call(FinanceiroMovimentoTipoSeeder::class);
        $this->call(FinanceiroLancamentoTipoSeeder::class);
        $this->call(FinanceiroLancamentoTipoLancamentoTipoSeeder::class);
        $this->call(FinanceiroContaGerencialTipoSeeder::class);
        $this->call(FinanceiroContaGerencialSeeder::class);
        $this->call(FinanceiroContaFinanceiraSeeder::class);
        $this->call(TransportadoraSeeder::class);
        $this->call(FinanceiroFormaRecebimentoSeeder::class);
        $this->call(FiscalRegimeTributarioSeeder::class);
        $this->call(FiscalCFOPSeeder::class);
        $this->call(FiscalCESTSeeder::class);
        $this->call(ProdutoSeeder::class);
        $this->call(VendaSituacaoSeeder::class);
        $this->call(EmpresaRamoAtividadeSeeder::class);
        $this->call(FinanceiroContaReceberSituacaoSeeder::class);
        $this->call(FinanceiroContaPagarSituacaoSeeder::class);       
        $this->call(FinanceiroLancamentoDocumentoTipoSeeder::class);              
    }
}
