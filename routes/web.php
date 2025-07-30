<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


use App\Models\Admin;

Route::get('/test-db', function () {
    try {
        $admin = Admin::first();
        return response()->json(['success' => true, 'admin' => $admin]);
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
});
