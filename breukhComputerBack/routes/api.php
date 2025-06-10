<?php

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AmiController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\SuccursaleController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\CaracteristiqueController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\MarqueController;
use App\Models\Caracteristique;

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


Route::post('products/search2', [ProductController::class, 'search2']);
Route::post('products/search', [ProductController::class, 'search']);

Route::post('commande/add', [CommandeController::class, 'store']);

Route::apiResource('marques', MarqueController::class);
Route::apiResource('categories', CategorieController::class);

Route::apiResource('products', ProductController::class);

Route::apiResource('succursales', SuccursaleController::class);

Route::apiResource('caracteristiques', CaracteristiqueController::class);
Route::post('utilisateurs/login', [UtilisateurController::class, 'login']);
Route::post('utilisateurs/logout', [UtilisateurController::class, 'logout']);

Route::apiResource('utilisateurs', UtilisateurController::class);

//Route::apiResource('commande', CommandeController::class);

Route::apiResource('clients', ClientController::class);

Route::apiResource('ristiques', CaracteristiqueController::class);

Route::apiResource('unites', UniteController::class);

Route::apiResource('amis', AmiController::class);

Route::apiResource('products', ProductController::class);

Route::middleware('auth:sanctum')->group(function () {
});


// /////////
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/user', [AuthController::class, 'user']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::get('/succursales/{id}/search/{code}', [ProduitController::class, 'search']);

//     Route::controller(AmiController::class)->prefix('/succursales/{id}/')->group(function () {
//         Route::get('friends',  'listeSuccursalesFriends');
//         Route::get('others',  'listeSuccursalesOthers');
//         Route::get('wait',  'listeSuccursalesWait');
//     });
// });
// Route::post('commande',[CommandeController::class,'store']);