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
  });
});