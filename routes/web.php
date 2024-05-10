<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProblemCategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TravaillerController;
use App\Models\Technician;
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/companies/dashboard', [CompanyController::class, 'dashboard'])->name('companies.dashboard');
    Route::resource('/companies', CompanyController::class);
    Route::resource('/applications', ApplicationController::class);
    Route::resource('/problem_categories', ProblemCategoryController::class);
    Route::get('/technicians/dashboard', [TechnicianController::class, 'dashboard'])->name('technicians.dashboard');
    Route::resource('/technicians', TechnicianController::class);
    Route::get('/tickets/myindex', [TicketController::class, 'myindex'])->name('tickets.myindex');
    Route::resource('/tickets', TicketController::class);

    Route::resource('/travaillers', TravaillerController::class);
});



require __DIR__ . '/auth.php';
