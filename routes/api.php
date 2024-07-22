<?php

use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/users', function (Request $request) {
//     //return $request->user();
//     return response()->json([
//         'status' => 200,
//         'message' => 'Listar usuarios'
//     ]);
// });

Route::get('/customers', [CustomerController::class,'index']); // GET - http://127.0.0.1:8000/api/customers?page=1
Route::get('/customers/{customer}', [CustomerController::class,'show']); // GET - http://127.0.0.1:8000/api/customers/1
Route::post('/customers', [CustomerController::class,'store']); // POST - http://127.0.0.1:8000/api/customers/1
Route::delete('/customers/{customer}', [CustomerController::class,'destroy']); // POST - http://127.0.0.1:8000/api/customers/1