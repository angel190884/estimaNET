<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');




Route::resource('contract', 'ContractController')->middleware('auth');
Route::resource('estimate', 'EstimateController')->middleware('auth');
Route::resource('concept', 'ConceptController')->middleware('auth');

Route::resource('generator', 'GeneratorController');
Route::get 		('generatorList/{estimate}', ['as' 	=>	'generator.list', 'uses'	=>	'GeneratorController@list']);

Route::resource('subGenerator', 'SubGeneratorController');

Route::resource('location', 'LocationController');
