<?php

namespace App\Http\Routes;

use Route;

class ProdutoRoute 
{
    public static function rotas(){
        Route::controller('produto', 'Sistema\Produto\ProdutoController');
        Route::controller('produtoestoque', 'Sistema\Produto\ProdutoEstoqueController');
        Route::controller('produtocategoria', 'Sistema\Produto\Categoria\ProdutoCategoriaController');
        Route::controller('produtomarca', 'Sistema\Produto\Marca\ProdutoMarcaController');
        Route::controller('produtoregrafiscal', 'Sistema\Produto\RegraFiscal\ProdutoRegraFiscalController');
        Route::controller('produtofornecedor', 'Sistema\Produto\Fornecedor\ProdutoFornecedorController');
        Route::controller('produtopreco', 'Sistema\Produto\ProdutoPrecoController');
    } 
}
