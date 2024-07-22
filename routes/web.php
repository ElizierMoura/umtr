<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('customers');;
});

Route::get('/customers', function () {
    return view('customers');
});