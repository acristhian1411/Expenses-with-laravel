<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthController;


Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::get('/register', function () {
    return Inertia::render('Register/index');
});
Route::group(['middleware' => ['auth']],function(){

    Route::get('/roles', function () {
        return Inertia::render('Roles/index');
    })->middleware('permission:roles.index');

    Route::get('/roles/{id}', function ($id) {
        return Inertia::render('Roles/show', ['id' => $id]);
    })->middleware('permission:roles.show');

    Route::get('/users', function () {
        return Inertia::render('Users/index');
    })->middleware('permission:users.index');

    Route::get('/users/{id}', function ($id) {
        return Inertia::render('Users/show', ['id' => $id]);
    })->middleware('permission:users.show');

    Route::get('/persontypes', function () {
        return Inertia::render('PersonTypes/index');
    })->middleware('permission:persontypes.index');
    
    Route::get('/persontypes/{id}', function ($id) {
        return Inertia::render('PersonTypes/show', ['id' => $id]);
    })->middleware('permission:persontypes.show');
    
    Route::get('/countries', function () {
        return Inertia::render('Countries/index');
    })->middleware('permission:countries.index');
    
    Route::get('/countries/{id}', function ($id) {
        return Inertia::render('Countries/show', ['id' => $id]);
    })->middleware('permission:countries.show');
    
    Route::get('/states', function () {
        return Inertia::render('States/index');
    })->middleware('permission:states.index');
    
    Route::get('/states/{id}', function ($id) {
        return Inertia::render('States/show', ['id' => $id]);
    })->middleware('permission:states.show');
    
    Route::get('/cities', function () {
        return Inertia::render('Cities/index');
    })->middleware('permission:cities.index');
    
    Route::get('/cities/{id}', function ($id) {
        return Inertia::render('Cities/show', ['id' => $id]);
    })->middleware('permission:cities.show');
    
    Route::get('/tills',function(){
        return Inertia::render('Tills/index');
    })->middleware('permission:tills.index');

    Route::get('/tills/{id}', function ($id) {
        return Inertia::render('Tills/show', ['id' => $id]);
    })->middleware('permission:tills.show');

    Route::get('/tilltypes', function () {
        return Inertia::render('TillTypes/index');
    })->middleware('permission:tilltypes.index');
    
    Route::get('/tilltypes/{id}', function ($id) {
        return Inertia::render('TillTypes/show', ['id' => $id]);
    })->middleware('permission:tilltypes.show');
    
    Route::get('/ivatypes', function () {
        return Inertia::render('IvaTypes/index');
    })->middleware('permission:ivatypes.index');
    
    Route::get('/ivatypes/{id}', function ($id) {
        return Inertia::render('IvaTypes/show', ['id' => $id]);
    })->middleware('permission:ivatypes.show');
    
    Route::get('/categories', function () {
        return Inertia::render('Categories/index');
    })->middleware('permission:categories.index');
    
    Route::get('/categories/{id}', function ($id) {
        return Inertia::render('Categories/show', ['id' => $id]);
    })->middleware('permission:categories.show');
    
    Route::get('/paymenttypes', function () {
        return Inertia::render('PaymentTypes/index');
    })->middleware('permission:paymenttypes.index');
    
    Route::get('/paymenttypes/{id}', function ($id) {
        return Inertia::render('PaymentTypes/show', ['id' => $id]);
    })->middleware('permission:paymenttypes.show');

    Route::get('/brands', function () {
        return Inertia::render('Brands/index');
    })->middleware('permission:brands.index');

    Route::get('/brands/{id}', function ($id) {
        return Inertia::render('Brands/show', ['id' => $id]);
    })->middleware('permission:brands.show');

    Route::get('/products', function () {
        return Inertia::render('Products/index');
    })->middleware('permission:products.index');

    Route::get('/products/{id}', function ($id) {
        return Inertia::render('Products/show', ['id' => $id]);
    })->middleware('permission:products.show');
});


Route::get('/', function () {
    return Inertia::render('Home', ['name' => 'Usuario']);
});


Route::get('/login', function () {
    return Inertia::render('Login/index');
})->name('login');

