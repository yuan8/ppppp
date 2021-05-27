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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->name('admin.')->middleware('auth:web')->group(function(){
	Route::prefix('data/')->name('data.')->group(function(){
		Route::post('/store', 'DataCtrl@store')->name('store');
		Route::get('/', 'DataCtrl@index')->name('index');
		Route::get('/render-dokumen/{id}/{slug?}', 'DataCtrl@render')->name('render');
		Route::get('/show-file/{id}/{slug?}', 'DataCtrl@show_file')->name('show_file');
		Route::get('/create/{type_id}/{slug?}', 'DataCtrl@create')->name('create');
		Route::get('/edit/{id}', 'DataCtrl@edit')->name('edit');
		Route::put('/edit/{id}', 'DataCtrl@update')->name('update');
		Route::delete('/delete/{id}', 'DataCtrl@delete')->name('delete');

	});

	Route::prefix('post-type')->middleware('can:is_supper')->name('post-type.')->group(function(){
		Route::post('/store', 'PostTypeCtrl@store')->name('store');
		Route::get('/', 'PostTypeCtrl@index')->name('index');
		Route::get('/create', 'PostTypeCtrl@create')->name('create');
		Route::delete('/delete/{id}/{slug?}', 'PostTypeCtrl@delete')->name('delete');
		Route::get('/edit/{id}/{slug?}', 'PostTypeCtrl@edit')->name('edit');
		Route::put('/edit/{id}/{slug?}', 'PostTypeCtrl@update')->name('update');


	});



	Route::prefix('user')->name('users.')->group(function(){
		Route::post('/store', 'UserCtrl@store')->middleware('can:is_supper')->name('store');
		Route::get('/', 'UserCtrl@index')->middleware('can:is_supper')->name('index');
		Route::get('/create', 'UserCtrl@create')->middleware('can:is_supper')->name('create');
		Route::delete('/delete/{id}/{slug?}', 'UserCtrl@creat')->middleware('can:is_supper')->name('delete');
		Route::get('/edit/{id}/{slug?}', 'UserCtrl@edit')->name('edit');
		Route::put('/edit/{id}/{slug?}', 'UserCtrl@update')->name('update');
		Route::put('/passoword/{id}/{slug?}', 'UserCtrl@update_password')->name('password');



	});



	Route::prefix('personil')->name('personil.')->group(function(){
		Route::post('/store', 'PersonilCtrl@store')->name('store');
		Route::get('/', 'PersonilCtrl@index')->name('index');
		Route::get('/create', 'PersonilCtrl@create')->name('create');
		Route::delete('/delete/{id}/', 'PersonilCtrl@delete')->name('delete');
		Route::get('/edit/{id}/{slug?}', 'PersonilCtrl@edit')->name('edit');
		Route::put('/edit/{id}/{slug?}', 'PersonilCtrl@update')->name('update');


	});

	Route::prefix('laporan')->name('laporan.')->group(function(){
		Route::post('/store', 'DataCtrl@store')->name('store');
		Route::get('/', 'PostTypeCtrl@index')->name('index');
		Route::get('/create', 'PostTypeCtrl@create')->name('create');
		Route::delete('/delete/{id}/{slug?}', 'PostTypeCtrl@creat')->name('delete');
		Route::get('/edit/{id}/{slug?}', 'DataCtrl@edit')->name('edit');
		Route::put('/edit/{id}/{slug?}', 'DataCtrl@update')->name('update');
	});


	

	Route::prefix('taxonomy')->middleware('can:is_supper')->name('taxonomy.')->group(function(){
		Route::post('/store', 'TaxonomyCtrl@store')->name('store');
		Route::get('/', 'TaxonomyCtrl@index')->name('index');
		Route::get('/create/{type_id}/{slug?}', 'TaxonomyCtrl@create')->name('create');
		Route::get('/edit/{id}', 'TaxonomyCtrl@edit')->name('edit');
		Route::put('/edit/{id}', 'TaxonomyCtrl@update')->name('update');
		Route::delete('/delete/{id}', 'TaxonomyCtrl@delete')->name('delete');


	});

});

