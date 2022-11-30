<?php



use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
 use Illuminate\Support\Facades\Response;
 use App\Http\Controllers\OrderController;
use App\Http\Controllers\ParentsController;
 use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\SchoolController;

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



Route::get('school', [SchoolController::class, 'index']);
Route::get('school/{id}', [SchoolController::class, 'show']);
Route::post('school', [SchoolController::class, 'store'])->middleware('auth:api');
Route::put('school/{id}', [SchoolController::class, 'update'])->middleware('auth:api');
Route::delete('school/{id}', [SchoolController::class, 'destroy'])->middleware('auth:api');


Route::get('parents', [ParentsController::class, 'index']);
Route::get('parents/{id}', [ParentsController::class, 'show']);
Route::get('parents/school/{id}', [ParentsController::class, 'bySchool']);
 Route::post('parents', [ParentsController::class, 'store'])->middleware('auth:api');
Route::post('parents/{id}', [ParentsController::class, 'update'])->middleware('auth:api');
Route::delete('parents/{id}', [ParentsController::class, 'destroy'])->middleware('auth:api');

Route::get('orders', [OrderController::class, 'index'])->middleware('auth:api');
Route::get('orders/all', [OrderController::class, 'all'])->middleware('auth:api');
Route::get('orders/{id}', [OrderController::class, 'status'])->middleware('auth:api');
Route::post('orders', [OrderController::class, 'store'])->middleware('auth:api');
Route::delete('orders/{id}', [OrderController::class, 'destroy'])->middleware('auth:api');
