<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/payment/verify', function (Request $request) {
    $response = Http::post(env('PAY_IR_WEB_ROUTE_URL').'/api/payment/verify' , [
        'token' => $request->token,
        'status'=>$request->status
    ]);
    return redirect()->away(env('PAY_IR_WEB_ROUTE_URL').'/payment/successTransaction?token='.$request->token);
        // dd($response->json());
});
