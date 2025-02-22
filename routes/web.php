<?php

    use App\Http\Controllers\Client\PageController;
    use Illuminate\Support\Facades\Route;
Route::fallback(function () {
    return view('client.errors.404');
})->name('404');

Route::get('maintenance', function () {
    return view('client.errors.maintenance');
})->name('maintenance');

Route::get('/', [PageController::class, 'index'])->name('client.pages.index');
Route::get('/about-us', [PageController::class, 'aboutUs'])->name('client.pages.aboutUs');
