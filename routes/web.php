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
    return redirect()->route('entries.index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->as('admin.')
    ->middleware('auth')
    ->group(base_path('routes/admin/web.php'));

Route::resource('entries', 'Admin\EntriesController')
    ->only(['index', 'show']);

Route::get('entries/user/{id}', 'Admin\EntriesController@profile')->name('entries.profile');
Route::get('entries/{userId}/{friendlyUrl}', 'Admin\EntriesController@showBySlug')->name('entries.showBySlug');
