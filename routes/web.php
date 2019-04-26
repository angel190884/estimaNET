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
Route::resource('deduction', 'DeductionController')->middleware('auth');
Route::resource('estimate', 'EstimateController')->middleware('auth');
Route::get('monitoringEstimate', ['as' 	=>	'monitoring.index',	'uses' => 'EstimateController@monitoringIndex'])->middleware('auth');

Route::resource('concept', 'ConceptController')->middleware('auth');

Route::resource('generator', 'GeneratorController')->middleware('auth');
Route::get 		('generatorList/{estimate}', ['as' 	=>	'generator.list', 'uses'	=>	'GeneratorController@list'])->middleware('auth');

Route::resource('subGenerator', 'SubGeneratorController')->middleware('auth');

Route::resource('location', 'LocationController')->middleware('auth');

Route::prefix('report')->get('cumulativeControl/{estimate}',['as' => 'report.cumulativeControl', 'uses' => 'ReportController@cumulativeControl'])->middleware('auth');
Route::prefix('report')->get('cumulativeControlLocations/{estimate}',['as' => 'report.cumulativeControlLocations', 'uses' => 'ReportController@cumulativeControlLocations'])->middleware('auth');
