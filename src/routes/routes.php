<?php

Route::group(['prefix' => 'lpeprovinsi'], function() {
    Route::get('/','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getIndex');
    Route::get('/list','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getList');
    Route::get('/detail/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@detailLpeProvinsi');
    Route::get('/create','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@createLpeProvinsi');
    Route::post('/create','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@createLpeProvinsiSave');
    Route::get('/update/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@updateLpeProvinsi');
    Route::post('/update/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getIndex');
    Route::post('/delete/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getIndex');
    Route::post('/activate/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getIndex');
    Route::post('/unactivate/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getIndex');
    Route::get('/getKota/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getKota');
    Route::get('/json/{id}/{va}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@json');
    Route::get('/export/{id}','Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@export');
    Route::get('/getColumns', 'Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getColumns');
    Route::get('/getProvinsi', 'Satudata\Lpeprovinsi\Http\Controllers\LpeProvinsiController@getProvinsi');
});
