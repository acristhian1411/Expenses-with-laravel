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

Route::get('/countries', function () {
    return Inertia::render('Countries/index');
});

Route::get('/countries/{id}', function ($id) {
    return Inertia::render('Countries/show', ['id' => $id]);
});

Route::get('/states', function () {
    return Inertia::render('States/index');
});

Route::get('/states/{id}', function ($id) {
    return Inertia::render('States/show', ['id' => $id]);
});

Route::get('/cities', function () {
    return Inertia::render('Cities/index');
});

Route::get('/cities/{id}', function ($id) {
    return Inertia::render('Cities/show', ['id' => $id]);
});

Route::get('/tilltypes', function () {
    return Inertia::render('TillTypes/index');
});

Route::get('/tilltypes/{id}', function ($id) {
    return Inertia::render('TillTypes/show', ['id' => $id]);
});

Route::get('/ivatypes', function () {
    return Inertia::render('IvaTypes/index');
});

Route::get('/ivatypes/{id}', function ($id) {
    return Inertia::render('IvaTypes/show', ['id' => $id]);
});

Route::get('/categories', function () {
    return Inertia::render('Categories/index');
});

Route::get('/categories/{id}', function ($id) {
    return Inertia::render('Categories/show', ['id' => $id]);
});

Route::get('/paymenttypes', function () {
    return Inertia::render('PaymentTypes/index');
});

Route::get('/paymenttypes/{id}', function ($id) {
    return Inertia::render('PaymentTypes/show', ['id' => $id]);
});