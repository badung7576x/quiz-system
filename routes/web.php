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
    Route::get('login', 'LoginController@create')->middleware('guest')->name('login');
    Route::post('login', 'LoginController@store')->middleware('guest');
    Route::post('logout', 'LoginController@destroy')->middleware('auth')->name('logout');
    Route::get('questions/form', 'QuestionController@renderForm')->name('question.form');
});

Route::group([
    'prefix' => 'admin',
    'namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.'
], function () {
    Route::get('questions/form', 'QuestionController@renderForm')->name('question.form');
});

Route::group([
    'prefix' => 'admin', 'middleware' => 'auth',
    'namespace' => 'App\Http\Controllers\Admin', 'as' => 'admin.'
], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    // Subject
    Route::resource('subjects', 'SubjectController')->names('subject');

    // Question Set
    Route::resource('question-sets', 'QuestionSetController')->names('question-set');

    // Teacher
    Route::resource('teachers', 'TeacherController')->names('teacher');

    // Question
    Route::resource('questions', 'QuestionController')->names('question');
});