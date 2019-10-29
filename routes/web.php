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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/questions','QuestionController');

// route set for all answer for a particular question
// ---------------------------------------------------
Route::resource('/questions.answers','AnswerController')->except(['index','create','show']);

// route set for favorite answer
// -------------------------------
Route::post('/answers/{answer}/accept', 'AcceptAnswerController')->name('answers.accept');

// route set for favorite question mark
// -----------------------------------

Route::post('/questions/{question}/favorite','FavoriteQuestionController@store')->name('questions.favorite');
Route::delete('/questions/{question}/favorite','FavoriteQuestionController@destroy')->name('questions.favorite');

// voting the question
// --------------------

Route::post('/questions/{question}/vote','VoteQuestionController')->name('questions.vote');

// voting the answer
// --------------------
Route::post('/answers/{answer}/vote','VoteAnswerController')->name('answers.vote');
