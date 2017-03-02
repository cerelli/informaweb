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

Route::get('/', function () {
    return view('welcome');
});

/* ================== Homepage + Admin Routes ================== */

require __DIR__.'/admin_routes.php';

Route::get('test', 'TestsController@getIndex');

Route::get('data', 'TestsController@anyData')->name('test.data');
