<?php

// Admin Interface Routes
Route::group([
    'namespace'  => 'Backpack\LangFileManager\app\Http\Controllers',
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    ], function () {
        // Language
        Route::get('language/texts/{lang?}/{file?}', 'LanguageCrudController@showTexts');
        Route::post('language/texts/{lang}/{file}', 'LanguageCrudController@updateTexts');
        CRUD::resource('language', 'LanguageCrudController');
    });
