<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\SpatieTestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\ForgetController;

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

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'autUser']);

Route::controller(AuthController::class)->group(function(){
    Route::post('/login','login');
    // Route::post('/register','register');
    
   
});

// profile
Route::controller(ProfileController::class)->group(function(){
    Route::post('/edtitprofile','EditProfile');
    Route::post('/change_password','changePass');
});


// company
Route::controller(CompanyController::class)->group(function(){
    Route::post('/registercompany','registerCompany');
});


// Invitations
Route::controller(InvitationController::class)->group(function(){
    Route::post('/inviteorg','Orgnization');
    Route::post('/inviteemployee','Employee');
});
// employee
Route::controller(EmployeeController::class)->group(function(){
    Route::post('/registeremployee','registerEmployee');
});


Route::post('/reset',[ResetController::class,'Reset']);
Route::post('/forget',[ForgetController::class,'Forget']);

Route::controller(SpatieTestController::class)->group(function(){
    Route::get('/test', 'index');
});
