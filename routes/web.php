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

    Route::group(['prefix' => 'reviews', 'as' => 'reviews::'], function() {
      Route::get('/', 'Admin\ReviewsController@index')->name('admin.reviews.index');
    });

    Route::group(['prefix' => 'respondents', 'as' => 'respondents::'], function(){
      Route::get('/', 'Admin\RespondentsController@index')->name('admin.respondents.index');
      Route::post('/', 'Admin\RespondentsController@store')->name('admin.respondents.store');
      Route::get('/create', 'Admin\RespondentsController@create')->name('admin.respondents.create');
    });

    Route::group(['prefix' => 'mailchimp', 'as' => 'mailchimp::'], function(){
      Route::post('/fetch', 'Admin\MailchimpController@fetch')->name('admin.mailchimp.fetch');
      Route::post('/send-survey', 'Admin\MailchimpController@sendSurveys')->name('admin.mailchimp.send-survey');
    });

  });
});