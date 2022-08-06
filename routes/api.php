<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\AdViewController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RecievedResumeController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TransactionController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::Post('/checkotp', [AuthController::class, 'checkOtp']);
    Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
    Route::Post('/firstSignUp', [AuthController::class, 'firstSignUp'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

Route::post('/getEmployerAds', [AdsController::class, 'getEmployerAds'])->middleware('auth:sanctum');
Route::post('/getSearchedAds', [AdsController::class, 'getSearched']);

Route::get('/getmyEmployerAds', [AdsController::class, 'getmyEmployerAds'])->middleware('auth:sanctum');
Route::get('/mainPageAds', [AdsController::class, 'mainPageAds']);
Route::Post('/getAdList', [AdsController::class, 'adList']);
Route::get('/getAds', [AdsController::class, 'index']);


Route::prefix('/ads')->middleware(['auth:sanctum'])->group(function () {
    Route::Post('/submitAd', [AdsController::class, 'storeAd']);
    Route::Post('/submitre', [ResumeController::class, 'storeRe']);
    Route::Post('/storeMedia', [AdsController::class, 'store_media']);
    Route::Post('/updateMedia', [AdsController::class, 'update_media']);
    Route::post('/getEditableAd', [AdsController::class, 'getEditableAd']);
    Route::Post('/updateAd', [AdsController::class, 'update']);
    Route::post('/storesavead/{ad}', [AdsController::class, 'storeSaveAd']);
});
Route::get('/ads/{ad:id}', [AdsController::class, 'show'])->middleware('VisitCount');

Route::get('/storeAdViews', [AdViewController::class, 'store']);
Route::post('/getAdViews', [AdViewController::class, 'index']);
Route::get('/getIp', [AdViewController::class, 'getIp']);
Route::post('/getProductPrice', [ProductController::class, 'getProductPrice']);


Route::prefix('/employee')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/myAds', [EmployeeController::class, 'getmyEmployeeAds']);
    Route::get('/suggestedAds', [EmployeeController::class, 'SuggestAds']);
    Route::get('/savedAds', [EmployeeController::class, 'SavedAds']);
    Route::get('/sentResumes', [RecievedResumeController::class, 'getMySentResumes']);
    Route::post('/sendResumeToEmployer', [RecievedResumeController::class, 'store']);
    Route::get('/getResume', [ResumeController::class, 'getResume']);
});

Route::prefix('/employer')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/myAds', [EmployerController::class, 'getmyEmployerAds']);
    Route::get('/suggestedAds', [EmployerController::class, 'SuggestAds']);
    Route::get('/savedAds', [EmployerController::class, 'SavedAds']);
    Route::get('/recievedResume', [RecievedResumeController::class, 'index']);
});

Route::post('/payment/send', [PaymentController::class, 'send'])->middleware('auth:sanctum');
Route::post('/payment/verify', [PaymentController::class, 'verify']);
Route::post('/transaction/show', [TransactionController::class, 'show']);
Route::get('/transaction/index', [TransactionController::class, 'index'])->middleware('auth:sanctum');





// Admin Panel 
Route::prefix('/admin')->middleware(['auth:sanctum'])->group(function () {
    Route::Post('/permissionRegister', [PermissionController::class, 'store']);
    Route::Post('/roleRegister', [RoleController::class, 'store']);
    Route::get('/getPermissions', [PermissionController::class, 'index']);
    Route::get('/getUsers_Roles', [RoleController::class, 'users_roles']);
    Route::Post('/assignPermission', [PermissionController::class, 'assignPermission']);
    Route::Post('/assignRoletoUser', [RoleController::class, 'assignRoletoUser']);
    Route::get('/getAds', [AdminController::class, 'adminAds']);
    Route::get('/getUsers', [AdminController::class, 'adminUsers']);
    Route::get('/getPayments', [AdminController::class, 'adminPayments']);
    Route::get('/getProducts', [AdminController::class, 'adminProducts']);
    Route::get('/getRoles', [AdminController::class, 'adminRoles']);
    Route::Post('/ChangeAdStatus', [AdminController::class, 'adminChangeStatus']);
    Route::Post('/RejectAd', [AdminController::class, 'adminRejectAd']);
});
