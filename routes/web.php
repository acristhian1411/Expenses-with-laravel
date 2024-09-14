<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', function () {
    return Inertia::render('Home', ['name' => 'Pepe']);
});

Route::get('/persontypes', function () {
    return Inertia::render('PersonTypes/index');
});

Route::get('/persontypes/{id}', function ($id) {
    return Inertia::render('PersonTypes/show', ['id' => $id]);
});