<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/bills', [BillController::class, 'index'])->middleware(['auth'])->name('bills-index');

Route::get('/bills/create', [BillController::class, 'create'])->middleware(['auth'])->name('bills-create');

Route::get('/bills/{bill}/edit', [BillController::class, 'edit'])->middleware(['auth'])->name('bills-edit');

Route::post('/bills', [BillController::class, 'store'])->middleware(['auth'])->name('bills-store');

Route::put('/bills/{bill}', [BillController::class, 'update'])->middleware(['auth'])->name('bills-update');

Route::delete('/bills/{bill}', [BillController::class, 'destroy'])->middleware(['auth'])->name('bills-destroy');

require __DIR__.'/auth.php';
