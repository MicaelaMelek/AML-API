<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace'=>'api'], function() {
    $this->resource('/clientes', 'ClienteController', ['except' => ['create', 'edit', 'destroy']]);
    $this->resource('/empresas', 'EmpresaController', ['except' => ['create', 'edit', 'destroy']]);
    $this->resource('/facturas', 'FacturaController', ['except' => ['create', 'edit', 'destroy']]);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
