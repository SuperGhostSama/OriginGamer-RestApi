<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ResetPasswordController;

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
//Authentification
Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    
});

//Forgot-Reset password 
Route::group(['controller' => ResetPasswordController::class], function (){
    // Request password reset link
    Route::post('forgot-password', 'sendResetLinkEmail')->middleware('guest')->name('password.email');
    // Reset password
    Route::post('reset-password', 'resetPassword')->middleware('guest')->name('password.update');

    Route::get('reset-password/{token}', function (string $token) {
         return $token;
     })->middleware('guest')->name('password.reset');
});
// Profile
Route::group(['controller' => ProfileController::class,'middleware'=>'auth:api'], function () {
    Route::put('user/{user}','updateProfile')->middleware('permission:edit my profile|edit all profile');
    Route::delete('user/{user}','deleteProfile')->middleware('permission:delete my profile|delete all profile');
});


// Categories
Route::group(['controller' => CategoriesController::class,'middleware'=>'auth:api'], function () {
    Route::get('/categories','index')->middleware(['permission:view category']);;
    Route::post('/categories','store')->middleware(['permission:add category']);
    Route::get('/categories/{category}','show')->middleware(['permission:view category']);;
    Route::put('/categories/{category}','update')->middleware(['permission:edit category']);
    Route::delete('/categories/{category}','destroy')->middleware(['permission:delete category']);
});

//Products
Route::group(['controller' => ProductsController::class,'middleware'=>'auth:api'], function () {
    Route::get('/products','index');
    Route::get('/products/{product}','show');
    Route::post('/products','store')->middleware(['permission:add product']);
    Route::put('/products/{product}','update')->middleware(['permission:edit All product|edit My product']);
    Route::delete('/products/{product}','destroy')->middleware(['permission:delete All product|delete My product']);
});

//Permissions
Route::group(['controller' => PermissionController::class,'middleware'=>'auth:api'], function () {
Route::post('assign-permission/{role}','assignPermissionToRole')->middleware('permission:assign permission');
Route::delete('remove-permission/{role}','removePermissionFromRole')->middleware('permission:assign permission');
});

//Roles
