<?php

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

Route::middleware([
    'web',
])->group(function () {
    Route::webauthn();
    Route::get('/temp/{filename}', function ($filename) {
        $path = sys_get_temp_dir() . '/' . $filename;
        if (file_exists($path)) {
            return response()->file($path);
        }
        abort(404);
    });
});
