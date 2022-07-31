<?php

use Illuminate\Support\Facades\Route;

Route::post('/', 'Auth\AjaxController@ajax_login')->name('admin.page.ajax');

Route::post('/login','Auth\AjaxController@ajax_login')->name('admin.ajax.post.login');
Route::post('/forgot', 'Auth\AjaxController@ajax_forgot')->name('admin.ajax.post.forgot');