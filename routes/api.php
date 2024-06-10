<?php

use App\Http\Controllers\Api\JTicketController;
use App\Http\Controllers\Api\TicketController;
use App\Models\Technician;
use App\Notifications\NewTicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// Affiche une liste de tous les tickets

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth.apikey')->name('api.')->group(function () {
//     Route::resource('jtickets', JTicketController::class);
// });
Route::middleware('auth.apikey')->name('api.')->group(function () {
    Route::resource('tickets', TicketController::class);

});
Route::get('/test-notification', function () {
    $ticket = App\Models\Ticket::find(34); // Récupérez un ticket existant pour le test
    $technician = Technician::find(3); // Récupérez un technicien existant pour le test

    Notification::send($technician, new NewTicketNotification($ticket));

    return 'Notification envoyée!';
});
