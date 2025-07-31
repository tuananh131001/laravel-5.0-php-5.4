<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('dashboard');
});

Route::get('dashboard', [
    'middleware' => 'auth',
    'uses' => function () {
        return view('dashboard');
    }
]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Brand routes
Route::resource('brands', 'BrandController');
Route::patch('brands/{brand}/toggle-status', [
	'as' => 'brands.toggle-status',
	'uses' => 'BrandController@toggleStatus'
]);

// Product routes
Route::resource('products', 'ProductController');
Route::patch('products/{product}/toggle-status', [
	'as' => 'products.toggle-status',
	'uses' => 'ProductController@toggleStatus'
]);

// Client routes
Route::resource('clients', 'ClientController');

// Card routes
Route::resource('cards', 'CardController', ['except' => ['edit', 'update']]);
Route::patch('cards/{card}/cancel', [
    'as' => 'cards.cancel',
    'uses' => 'CardController@cancel'
]);

// Report routes
Route::get('reports/spending', [
    'as' => 'reports.spending',
    'uses' => 'ReportController@spendingForm'
]);
Route::post('reports/spending', [
    'as' => 'reports.spending.generate',
    'uses' => 'ReportController@generateSpendingReport'
]);
Route::get('reports/cancellation', [
    'as' => 'reports.cancellation',
    'uses' => 'ReportController@cancellationForm'
]);
Route::post('reports/cancellation', [
    'as' => 'reports.cancellation.generate',
    'uses' => 'ReportController@generateCancellationReport'
]);
