<?php

use App\Http\Controllers\Admin\PageController;
use \Illuminate\Support\Facades\Route;


Route::get('/admin', [PageController::class, 'index'])->name('admin.pages.index');
