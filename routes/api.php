<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartContoller;
use App\Http\Controllers\Api\OrderContoller;
use App\Http\Controllers\Api\ProductContoller;
use App\Http\Controllers\Api\RecordController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\StripePaymentControoler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Auth End-Point
Route::post('login',[AuthController::class,'logIn']);
Route::post('registration',[AuthController::class,'registration']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::group(['middleware' =>  ['role:admin']], function () {

        //Product End-Point
        Route::get('products/list',[ProductContoller::class,'index']);
        Route::post('products/create',[ProductContoller::class,'store']);
        Route::post('products/update/{id}',[ProductContoller::class,'update']);
        Route::get('products/details/{id}',[ProductContoller::class,'show']);
        Route::delete('products/delete/{id}',[ProductContoller::class,'destroy']);

        //Order End-Point
        Route::get('order', [OrderContoller::class, 'index']);
        Route::get('order/{id}', [OrderContoller::class, 'show']);
        Route::delete('order/{id}',[OrderContoller::class,'destroy']);

        //Minimum Selling Product End-Point
        Route::get('min-selling-product',[ReportController::class,'MinSellingProduct']);
    });

    Route::group(['middleware' =>  ['role:user']], function () {

        //Add To Cart End-Point
        Route::post('addtocart',[CartContoller::class, 'addToCart']);
        Route::put('updatecartproduct',[CartContoller::class, 'updateCartProduct']);

        //Order Create/Update End-Point
        Route::post('order', [OrderContoller::class,'store']);
        Route::put('order/{id}', [OrderContoller::class, 'update']);

        Route::post('payment', [StripePaymentControoler::class, 'CreateCardDetails']);
    });


    Route::post('logout', [AuthController::class, 'logOut']);
});
