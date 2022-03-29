<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Auth', 'as' => 'admin.'
], function () {
    Route::get('login', 'AuthenticatedSessionController@create')->middleware('guest')->name('login');
    Route::post('login', 'AuthenticatedSessionController@store')->middleware('guest');
    Route::post('logout', 'AuthenticatedSessionController@destroy')->middleware('auth')->name('logout');
});

Route::group([
    'prefix' => 'admin', 'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.'
], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    // Class
    Route::resource('classes', 'ClassController')->names('class');

    // Student
    Route::post('{class}/student/import', 'StudentController@importExcel')->name('student.import');
    Route::resource('classes.students', 'StudentController')->names('student');
});
