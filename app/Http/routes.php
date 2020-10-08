<?php
use App\Http\Routes\AutenticacaoRoute;
use App\Http\Routes\CacheRoute;
use App\Http\Routes\FinanceiroRoute;
use App\Http\Routes\FiscalRoute;
use App\Http\Routes\HomeRoute;
use App\Http\Routes\ParametroRoute;
use App\Http\Routes\PessoaRoute;
use App\Http\Routes\ProdutoRoute;
use App\Http\Routes\VendaRoute;
use App\Http\Routes\ProducaoRoute;
use App\Http\Routes\GraficoRoute;
use App\Http\Routes\RelatorioRoute;

Route::get('/clear-all', function() {
    $exitCode = Artisan::call('cache:clear');
		$exitCode =    Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return '<h1>Cache ALL</h1>';
});


Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

AutenticacaoRoute::rotas();
FinanceiroRoute::rotas();
FiscalRoute::rotas();
HomeRoute::rotas();
ParametroRoute::rotas();
PessoaRoute::rotas();
ProdutoRoute::rotas();
VendaRoute::rotas();
ProducaoRoute::rotas();
GraficoRoute::rotas();
RelatorioRoute::rotas();