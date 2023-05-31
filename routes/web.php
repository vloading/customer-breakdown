<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MonthController;
use App\Http\Controllers\OrderListController;
use App\Http\Controllers\OrderSourceController;

Route::get('/', function () {
    return view('welcome');
});

// Order List
Route::get('/order-list', [OrderListController::class, 'view'])->name('list');

// Order Source
Route::get('/order-source', [OrderSourceController::class, 'view'])->name('source');

// Weekly Report Page
Route::get('/weekly-report', [MainController::class, 'viewWeek'])->name('week');

// Monthly Report
Route::get('/monthly-report', [MonthController::class, 'viewMonth'])->name('month');