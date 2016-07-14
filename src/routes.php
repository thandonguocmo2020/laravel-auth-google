<?php

Route::get('auth/google', 'Auth\GoogleController@redirectToProvider');
Route::get('auth/google/callback', 'Auth\GoogleController@handleProviderCallback');