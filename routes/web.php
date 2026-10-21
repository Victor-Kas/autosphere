<?php

use App\Http\Controllers\BreakdownController;
use App\Http\Controllers\BreakdownSolutionController;
use App\Http\Controllers\CommonFaultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleCatalogueController;
use Illuminate\Support\Facades\Route;

Route::view('/','home')->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/vehicles', [VehicleCatalogueController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{make}/{model}',[VehicleCatalogueController::class, 'show'])->name('vehicles.show');

Route::middleware('auth')->group(function () {
    Route::get('/breakdowns/create', [BreakdownController::class, 'create'])
        ->name('breakdowns.create');

    Route::post('/breakdowns', [BreakdownController::class, 'store'])
        ->name('breakdowns.store');
});


Route::get('/breakdowns', [BreakdownController::class, 'index'])
    ->name('breakdowns.index');

Route::get('/breakdowns/{breakdown}', [BreakdownController::class, 'show'])
    ->name('breakdowns.show');


Route::post('/breakdowns/{breakdown}/solutions', [BreakdownSolutionController::class, 'store'])
    ->middleware('auth')
    ->name('breakdowns.solutions.store');    


Route::patch(
    '/breakdowns/{breakdown}/solutions/{solution}/accept',
    [BreakdownSolutionController::class, 'accept']
)
->middleware('auth')
->name('breakdowns.solutions.accept');

Route::patch(
    '/breakdowns/{breakdown}/solutions/{solution}/accept',
    [BreakdownSolutionController::class, 'accept']
)
->middleware('auth')
->name('breakdowns.solutions.accept');

Route::get('/common-faults', [CommonFaultController::class, 'index'])
    ->name('common-faults.index');

Route::get('/common-faults/{fault}', [CommonFaultController::class, 'show'])
    ->name('common-faults.show');    


require __DIR__.'/auth.php';
