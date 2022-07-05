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

Route::get('/', function() {
    return redirect()->route('admin.login');
});

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
    Route::get('questions/reviews', 'QuestionController@reviews')->name('review.question');
    Route::get('questions/reviews/{question}', 'QuestionController@reviewShow')->name('review.show');
    Route::post('questions/import', 'QuestionController@import')->name('question.import');
    Route::resource('questions', 'QuestionController')->names('question');
    Route::get('questions/{question}/review', 'QuestionController@review')->name('question.review');
    Route::get('questions/{question}/template', 'QuestionController@contentTemplate')->name('question.template');

    // Question Bank
    Route::get('question-banks/waiting-accept', 'QuestionBankController@waitAccepts')->name('question-bank.wait-accept');
    Route::get('question-banks/{question_bank}/template', 'QuestionBankController@contentTemplate')->name('question-bank.template');
    Route::resource('question-banks', 'QuestionBankController')->names('question-bank');
    Route::get('question-banks/{question}/approved', 'QuestionBankController@approved')->name('question-bank.approved');
    
    // Comment
    Route::resource('questions.comments', 'CommentController')->names('comment');
    Route::post('questions/{question}/comments/{comment}/resolved', 'CommentController@resolved')->name('comment.resolved');

    // Exam set
    Route::get('exam-sets/{exam_set}/pdf/{exam_set_detail}', 'ExamSetController@pdf')->name('exam-set.pdf');
    Route::get('exam-sets/{exam_set}/setting', 'ExamSetController@setting')->name('exam-set.setting');
    Route::post('exam-sets/{exam_set}/setting', 'ExamSetController@saveSetting')->name('exam-set.setting.save');
    Route::get('exam-sets/{exam_set}/download', 'ExamSetController@download')->name('exam-set.download');
    Route::resource('exam-sets', 'ExamSetController')->names('exam-set');

    // Assignment
    Route::get('assignments', 'AssignmentController@index')->name('assignment.index');
    Route::post('assignments/assign', 'AssignmentController@assign')->name('assignment.assign');
});