<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

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


Route::get('/', [PetController::class, 'create'])->name('pet.create');

Route::post('/pet', [PetController::class, 'store'])->name('pet.store');

Route::get('/pet/show/{id}', [PetController::class, 'show'])->name('pet.show');

Route::delete('/pet/destroy/{id}', [PetController::class, 'destroy'])->name('pet.destroy');

Route::get('/pet/edit/{id}', [PetController::class, 'edit'])->name('pet.edit');

Route::put('/pet/update/{id}', [PetController::class, 'update'])->name('pet.update');

