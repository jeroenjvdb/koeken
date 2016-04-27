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
    return view('welcome');
});

Route::get('/koeken', ['as' => 'koeken.index', 'uses' => 'KoekenController@index']);
Route::get('/test', ['as' => 'koeken.text', 'uses' => 'KoekenController@slackCommand']);
Route::get('/koeken/{name}', ['as' => 'koeken.who', 'uses' => 'KoekenController@who']);
Route::post('/koeken', ['as' => 'koeken.text', 'uses' => 'KoekenController@slackCommand']);