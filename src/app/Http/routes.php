<?php

// Admin Interface Routes
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'auth']], function () {
    // Language
    Route::get('language/texts/{lang?}/{file?}', 'LanguageCrudController@showTexts');
    Route::post('language/texts/{lang}/{file}', 'LanguageCrudController@updateTexts');
    Route::resource('language', 'LanguageCrudController');
});
