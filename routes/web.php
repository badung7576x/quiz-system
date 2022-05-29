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

    // Teacher
    Route::resource('teachers', 'TeacherController')->names('teacher');

    // Question
    Route::get('questions/banks', 'QuestionController@banks')->name('question.bank');
    Route::get('questions/reviews', 'QuestionController@reviews')->name('review.question');
    Route::resource('questions', 'QuestionController')->names('question');
    Route::get('questions/{question}/review', 'QuestionController@review')->name('question.review');
    
    // Comment
    Route::resource('questions.comments', 'CommentController')->names('comment');
    Route::post('questions/{question}/comments/{comment}/resolved', 'CommentController@resolved')->name('comment.resolved');

    // Exam set
    Route::resource('exam-sets', 'ExamSetController')->names('exam-set');
    Route::get('exam-sets/{exam-set}/export', 'ExamSetController@export')->name('exam-set.export');

    // Assignment
    Route::get('assignments', 'AssignmentController@index')->name('assignment.index');
    Route::post('assignments/assign', 'AssignmentController@assign')->name('assignment.assign');
});