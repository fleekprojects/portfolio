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

// Route::get('/', function () {
    // return view('welcome');
// });
//FRONTEND
Route::get('/', ['uses' => 'Front\HomeController@index']);
Route::post('/', ['uses' => 'Front\HomeController@recordSearch']);
Route::get('/{guid}', ['uses' => 'Front\HomeController@getSearch']);

Route::get('/p/{id}', ['uses' => 'Front\BrandController@index']);
Route::post('/p/{id}', ['uses' => 'Front\BrandController@recordSearch']);
Route::get('/p/{id}/{guid}', ['uses' => 'Front\BrandController@getSearch']);

Route::post('/portal/brands/gen_php_file', ['uses' => 'AdminBrandsController@gen_php_file']);

// Route::get('/p', ['uses' => 'Front\Brand\BrandController@index']);
// Route::get('/p/{id}', ['uses' => 'Front\Brand\BrandController@search_brandname']);
// Route::get('/changecategory', ['uses' => 'Front\Home\HomeController@changeCategory']);
// Route::get('/searchtag', ['uses' => 'Front\Home\HomeController@searchTags']);
// Route::get('/viewportfolio/{number}', ['uses' => 'Front\Home\HomeController@viewporfolio']);
