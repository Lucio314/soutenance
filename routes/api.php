<?php

use App\Http\Controllers\Api\TicketController;
use Illuminate\Http\Request;
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
Route::get('/tickets', [TicketController::class, 'index'])->name('api.tickets.index');

// Affiche un formulaire pour créer un nouveau ticket
Route::get('/tickets/create', [TicketController::class, 'create'])->name('api.tickets.create');

// Stocke un nouveau ticket dans la base de données
Route::post('/tickets', [TicketController::class, 'store'])->name('api.tickets.store');

// Affiche les détails d'un ticket spécifique
Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('api.tickets.show');

// Affiche un formulaire pour modifier un ticket spécifique
Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('api.tickets.edit');

// Met à jour un ticket spécifique dans la base de données
Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('api.tickets.update');

// Supprime un ticket spécifique de la base de données
Route::delete('/tickets/{ticket}', [TicketController::class, 'destroy'])->name('api.tickets.destroy');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
