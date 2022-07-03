<?php

use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [UserController::class, 'dashboard'])->middleware('auth')->name('home');

Route::get('/manage-items', [UserController::class, 'viewItemsManagement'])->middleware('auth')->name('manage-items');

Route::get('/create-po', [UserController::class, 'createPo'])->middleware('auth');

Route::get('/view-item', [StoreController::class, 'viewItem'])->middleware('auth');;

Route::get('/register', [UserController::class, 'register']);

Route::get('/login', [UserController::class, 'login']);

Route::post('/login', [UserController::class, 'processLogin']);

Route::get('/logout', function(Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    return redirect('/login');
})->name('login');

Route::post('/store-store', [StoreController::class, 'store'])->middleware('auth');

Route::get('/load-store', [StoreController::class, 'loadStore'])->middleware('auth');

Route::post('/save-item', [StoreController::class, 'insertItem'])->middleware('auth');

Route::post('/update-item', [StoreController::class, 'updateItem'])->middleware('auth');

Route::post('/update-uom', [StoreController::class, 'updateUOMAttributes'])->middleware('auth');

Route::get('/get-recent-items', [StoreController::class, 'getRecentItems'])->middleware('auth');

// Route::get('/create-user', function (Request $request) {
//     return 'hello world';
// });
