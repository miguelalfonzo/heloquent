<?php
use App\Http\Controllers\V1\ProductsController;
use App\Http\Controllers\V1\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\WebController;

Route::prefix('v1')->group(function () {
    

 	
 	 Route::group(['prefix' => 'reservation','middleware' => ['jwt.verify']], function () {

	 	Route::get('search', [WebController::class, 'search']);

	 	Route::get('coupon', [WebController::class, 'coupon']);

	 	Route::post('create', [WebController::class, 'create']);

	 	Route::put('confirm', [WebController::class, 'confirm']);

	 	Route::get('getIgv', [WebController::class, 'getIgv']);

	 	
		
    });




    Route::get('products', [ProductsController::class, 'index']);
    Route::get('products/{id}', [ProductsController::class, 'show']);

     Route::post('products', [ProductsController::class, 'store']);
      Route::put('products/{id}', [ProductsController::class, 'update']);
      Route::delete('products/{id}', [ProductsController::class, 'destroy']);





    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);



    Route::group(['middleware' => ['jwt.verify']], function() {
        

        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('get-user', [AuthController::class, 'getUser']);

     
    });
});