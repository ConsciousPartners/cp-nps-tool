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


Auth::routes();

Route::get('/', 'SurveyController@index')->name('survey.index');

Route::group(['prefix' => 'survey', 'as' => 'survey::'], function() {
  Route::post('/submit', 'SurveyController@submit')->name('survey.submit');
  Route::get('/success', 'SurveyController@success')->name('survey.success');
});


Route::group(['middleware' => ['web', 'auth']], function (){
  Route::group(['prefix' => 'admin', 'as' => 'admin::'], function() {

    Route::get('/', 'Admin\AdminController@index')->name('admin.admin.index');

    Route::resource('reviews', 'Admin\ReviewsController', ['only' => [
      'index', 'create', 'store', 'destroy'
    ],
    ['names' => [
      'index' => 'reviews.index',
      'create' => 'reviews.create',
      'store' => 'reviews.store',
      'destroy' => 'reviews.destroy',
    ]]]);

    Route::resource('feedbacks', 'Admin\FeedbacksController', ['only' => [
      'index', 'create', 'store', 'destroy'
    ],
    ['names' => [
      'index' => 'feedbacks.index',
      'create' => 'feedbacks.create',
      'store' => 'feedbacks.store',
      'destroy' => 'feedbacks.destroy',
    ]]]);  

    Route::resource('respondents', 'Admin\RespondentsController', ['only' => [
      'index', 'create', 'store', 'destroy'
    ],
    ['names' => [
      'index' => 'respondents.index',
      'create' => 'respondents.create',
      'store' => 'respondents.store',
      'destroy' => 'respondents.destroy',
    ]]]);    

    Route::group(['prefix' => 'mailchimp', 'as' => 'mailchimp::'], function(){
      Route::post('/fetch', 'Admin\MailchimpController@fetch')->name('admin.mailchimp.fetch');
      Route::post('/send-survey', 'Admin\MailchimpController@sendSurveys')->name('admin.mailchimp.send-survey');
    });

  });
});