<?php

use App\Http\Controllers\Api\V1\CategoriaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    // Rotas das Categorias e Subcategorias
    Route::prefix('/categorias')->group(function () {
        Route::get('/', [CategoriaController::class, 'index'])->name('shippers.index');
        Route::post('/', [CategoriaController::class, 'store'])->name('shippers.store');
        Route::get('/{categoria}', [CategoriaController::class, 'show'])->name('shippers.show');
        Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('shippers.update');
        Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('shippers.destroy');
    });
});

