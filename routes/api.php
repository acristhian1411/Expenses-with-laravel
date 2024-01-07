<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TillTypes\TillTypeController;
use App\Http\Controllers\PersonTypes\PersonTypesController;
use App\Http\Controllers\AccountPlans\AccountPlanController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Cities\CitiesController;
use App\Http\Controllers\Countries\CountriesController;
use App\Http\Controllers\IvaTypes\IvaTypeController;
use App\Http\Controllers\PaymentTypes\PaymentTypesController;
use App\Http\Controllers\Persons\PersonsController;
use App\Http\Controllers\Products\ProductsController;
use App\Http\Controllers\States\StatesController;
use App\Http\Controllers\Tills\TillsController;
use App\Http\Controllers\TillDetails\TillDetailsController;
use App\Http\Controllers\TillDetailProofPayments\TillDetailProofPaymentsController;
use App\Http\Controllers\ProofPaypments\ProofPaymentsController;
use App\Http\Controllers\Sales\SalesController;
use App\Http\Controllers\SalesDetails\SalesDetailsController;
use App\Http\Controllers\Purchases\PurchasesController;
use App\Http\Controllers\PurchasesDetails\PurchasesDetailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//routes for tilltyoes
Route::get('tilltypes', [TillTypeController::class, 'index']);
Route::post('tilltypes', [TillTypeController::class, 'store']);
Route::put('tilltypes/{id}', [TillTypeController::class, 'update']);
Route::get('tilltypes/{id}', [TillTypeController::class, 'show']);
Route::delete('tilltypes/{id}', [TillTypeController::class, 'destroy']);

//routes for personTypes
Route::get('persontypes', [PersonTypesController::class, 'index']);
Route::post('persontypes', [PersonTypesController::class, 'store']);
Route::put('persontypes/{id}', [PersonTypesController::class, 'update']);
Route::get('persontypes/{id}', [PersonTypesController::class, 'show']);
Route::delete('persontypes/{id}', [PersonTypesController::class, 'destroy']);

//routes for accountplans
Route::get('accountplans', [AccountPlanController::class, 'index']);
Route::post('accountplans', [AccountPlanController::class, 'store']);
Route::put('accountplans/{id}', [AccountPlanController::class, 'update']);
Route::get('accountplans/{id}', [AccountPlanController::class, 'show']);
Route::delete('accountplans/{id}', [AccountPlanController::class, 'destroy']);
//routes for categories
Route::get('categories', [CategoriesController::class, 'index']);
Route::post('categories', [CategoriesController::class, 'store']);
Route::put('categories/{id}', [CategoriesController::class, 'update']);
Route::get('categories/{id}', [CategoriesController::class, 'show']);
Route::delete('categories/{id}', [CategoriesController::class, 'destroy']);
//routes for cities
Route::get('cities', [CitiesController::class, 'index']);
Route::post('cities', [CitiesController::class, 'store']);
Route::put('cities/{id}', [CitiesController::class, 'update']);
Route::get('cities/{id}', [CitiesController::class, 'show']);
Route::delete('cities/{id}', [CitiesController::class, 'destroy']);
//routes for countries
Route::get('countries', [CountriesController::class, 'index']);
Route::post('countries', [CountriesController::class, 'store']);
Route::put('countries/{id}', [CountriesController::class, 'update']);
Route::get('countries/{id}', [CountriesController::class, 'show']);
Route::delete('countries/{id}', [CountriesController::class, 'destroy']);
//routes for ivatypes
Route::get('ivatypes', [IvaTypeController::class, 'index']);
Route::post('ivatypes', [IvaTypeController::class, 'store']);
Route::put('ivatypes/{id}', [IvaTypeController::class, 'update']);
Route::get('ivatypes/{id}', [IvaTypeController::class, 'show']);
Route::delete('ivatypes/{id}', [IvaTypeController::class, 'destroy']);
//routes for paymenttypes
Route::get('paymenttypes', [PaymentTypesController::class, 'index']);
Route::post('paymenttypes', [PaymentTypesController::class, 'store']);
Route::put('paymenttypes/{id}', [PaymentTypesController::class, 'update']);
Route::get('paymenttypes/{id}', [PaymentTypesController::class, 'show']);
Route::delete('paymenttypes/{id}', [PaymentTypesController::class, 'destroy']);
//routes for persons
Route::get('persons', [PersonsController::class, 'index']);
Route::post('persons', [PersonsController::class, 'store']);
Route::put('persons/{id}', [PersonsController::class, 'update']);
Route::get('persons/{id}', [PersonsController::class, 'show']);
Route::delete('persons/{id}', [PersonsController::class, 'destroy']);
//routes for products
Route::get('products', [ProductsController::class, 'index']);
Route::post('products', [ProductsController::class, 'store']);
Route::put('products/{id}', [ProductsController::class, 'update']);
Route::get('products/{id}', [ProductsController::class, 'show']);
Route::delete('products/{id}', [ProductsController::class, 'destroy']);
//routes for states
Route::get('states', [StatesController::class, 'index']);
Route::post('states', [StatesController::class, 'store']);
Route::put('states/{id}', [StatesController::class, 'update']);
Route::get('states/{id}', [StatesController::class, 'show']);
Route::delete('states/{id}', [StatesController::class, 'destroy']);
//routes for tills
Route::get('tills', [TillsController::class, 'index']);
Route::post('tills', [TillsController::class, 'store']);
Route::put('tills/{id}', [TillsController::class, 'update']);
Route::get('tills/{id}', [TillsController::class, 'show']);
Route::delete('tills/{id}', [TillsController::class, 'destroy']);
//routes for tilldetails
Route::get('tilldetails', [TillDetailsController::class, 'index']);
Route::post('tilldetails', [TillDetailsController::class, 'store']);
Route::put('tilldetails/{id}', [TillDetailsController::class, 'update']);
Route::get('tilldetails/{id}', [TillDetailsController::class, 'show']);
Route::delete('tilldetails/{id}', [TillDetailsController::class, 'destroy']);
//routes for TillDetailProofPayments
Route::get('tilldetailproofpayments', [TillDetailProofPaymentsController::class, 'index']);
Route::post('tilldetailproofpayments', [TillDetailProofPaymentsController::class, 'store']);
Route::put('tilldetailproofpayments/{id}', [TillDetailProofPaymentsController::class, 'update']);
Route::get('tilldetailproofpayments/{id}', [TillDetailProofPaymentsController::class, 'show']);
Route::delete('tilldetailproofpayments/{id}', [TillDetailProofPaymentsController::class, 'destroy']);
//routes for ProofPaypments
Route::get('proofpaypments', [ProofPaymentsController::class, 'index']);
Route::post('proofpaypments', [ProofPaymentsController::class, 'store']);
Route::put('proofpaypments/{id}', [ProofPaymentsController::class, 'update']);
Route::get('proofpaypments/{id}', [ProofPaymentsController::class, 'show']);
Route::delete('proofpaypments/{id}', [ProofPaymentsController::class, 'destroy']);
//routes for sales
Route::get('sales', [SalesController::class, 'index']);
Route::post('sales', [SalesController::class, 'store']);
Route::put('sales/{id}', [SalesController::class, 'update']);
Route::get('sales/{id}', [SalesController::class, 'show']);
Route::delete('sales/{id}', [SalesController::class, 'destroy']);
//routes for salesdetails
Route::get('salesdetails', [SalesDetailsController::class, 'index']);
Route::post('salesdetails', [SalesDetailsController::class, 'store']);
Route::put('salesdetails/{id}', [SalesDetailsController::class, 'update']);
Route::get('salesdetails/{id}', [SalesDetailsController::class, 'show']);
Route::delete('salesdetails/{id}', [SalesDetailsController::class, 'destroy']);
//routes for Purchases
Route::get('purchases', [PurchasesController::class, 'index']);
Route::post('purchases', [PurchasesController::class, 'store']);
Route::put('purchases/{id}', [PurchasesController::class, 'update']);
Route::get('purchases/{id}', [PurchasesController::class, 'show']);
Route::delete('purchases/{id}', [PurchasesController::class, 'destroy']);
//routes for PurchasesDetails
Route::get('purchasesdetails', [PurchasesDetailsController::class, 'index']);
Route::post('purchasesdetails', [PurchasesDetailsController::class, 'store']);
Route::put('purchasesdetails/{id}', [PurchasesDetailsController::class, 'update']);
Route::get('purchasesdetails/{id}', [PurchasesDetailsController::class, 'show']);
Route::delete('purchasesdetails/{id}', [PurchasesDetailsController::class, 'destroy']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
