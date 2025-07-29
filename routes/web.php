<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrandController;

Route::get('/', fn () => redirect()->route('brand.index'));
Route::resource('brand', BrandController::class);
Route::resource('brand', \App\Http\Controllers\BrandController::class);
Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
