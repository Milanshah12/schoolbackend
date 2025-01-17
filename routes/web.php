<?php

use App\Http\Controllers\headingController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\permissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\servicesController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\tagController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth',)->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/users',userController::class);
    Route::resource('/roles',RoleController::class);
    Route::get('roles/{roleId}/give-permission',[RoleController::class,'addPermissionToRole']);
    Route::PUT('roles/{roleId}/give-permission',[RoleController::class,'givePermissionToRole']);




    Route::resource('/services',servicesController::class);
    Route::resource('/students',studentController::class);
    Route::get('/students/{id}/add',[studentController::class,'addservice']);
    Route::post('/students/{id}/add',[studentController::class,'insertservice']);


    Route::resource('/receipts',ReceiptController::class);
    Route::resource('/payments',paymentController::class);
    Route::resource('/headings',headingController::class);
    Route::resource('/permissions',permissionController::class);


    Route::resource('/tags',tagController::class);

});

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
