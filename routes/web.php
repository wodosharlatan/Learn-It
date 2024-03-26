<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\Reservation;

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

// Get routes

Route::get('/',[UserController::class,'hero']);
Route::get('/home', [ReservationController::class,'getReservations']);
Route::get('/admin-panel',[ReservationController::class,'AdminPanelReservationView']);

// Get routes => these prevents from resending the form data when the page is refreshed
Route::get('/new-reservation',[ReservationController::class,'newReservationGetMethod']);
Route::get('/delete-reservation/{id}', [ReservationController::class,'deleteReservationGetMethod']);

// Post routes
Route::post('/register', [UserController::class,'register']);
Route::post('/logout', [UserController::class,'logout']);
Route::post('/login', [UserController::class,'login']);
Route::post('/new-reservation', [ReservationController::class,'newReservation']);
Route::post('/delete-reservation/{id}', [ReservationController::class,'deleteReservation']);


