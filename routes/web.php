<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();
Route::get('home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('file-upload', [\App\Http\Controllers\FileUploadController::class, 'post'])->name('file.upload.post');
Route::get('export/{file_name}', [\App\Http\Controllers\FileUploadController::class, 'export'])->name('file.upload.export');
Route::get('export-using-package/{file_name}', [\App\Http\Controllers\FileUploadController::class, 'exportUsingPackage'])->name('file.upload.exportUsingPackage');
