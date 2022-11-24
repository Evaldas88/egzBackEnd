<?php



use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\DarzelisController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\TevaiController;
use App\Http\Controllers\PassportAuthController;

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

Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::post('logout', [PassportAuthController::class, 'logout'])->middleware('auth:api');
Route::get('authcheck', [PassportAuthController::class, 'index'])->middleware('auth:api');



Route::get('darzelis', [DarzelisController::class, 'index']);
Route::get('darzelis/{id}', [DarzelisController::class, 'show']);
Route::post('darzelis', [DarzelisController::class, 'store'])->middleware('auth:api');
Route::put('darzelis/{id}', [DarzelisController::class, 'update'])->middleware('auth:api');
Route::delete('darzelis/{id}', [DarzelisController::class, 'destroy'])->middleware('auth:api');


Route::get('tevai', [TevaiController::class, 'index']);
Route::get('tevai/{id}', [TevaiController::class, 'show']);
Route::get('tevai/darzelis/{id}', [TevaiController::class, 'byTevai']);
 Route::post('tevai', [TevaiController::class, 'store'])->middleware('auth:api');
Route::post('tevai/{id}', [TevaiController::class, 'update'])->middleware('auth:api');
Route::delete('tevai/{id}', [TevaiController::class, 'destroy'])->middleware('auth:api');

Route::get('orders', [OrdersController::class, 'index'])->middleware('auth:api');
Route::get('orders/all', [OrdersController::class, 'all'])->middleware('auth:api');
Route::get('orders/{id}', [OrdersController::class, 'status'])->middleware('auth:api');
Route::post('orders', [OrdersController::class, 'store'])->middleware('auth:api');
Route::delete('orders/{id}', [OrdersController::class, 'destroy'])->middleware('auth:api');
