<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('kampus', 'KampusController@index');
Route::post('kampus', 'KampusController@store');
Route::get('kampus/{id}', 'KampusController@show');
Route::post('kampus/update', 'KampusController@update');
Route::delete('kampus/{id}', 'KampusController@destroy');

Route::get('prodi', 'ProdiController@index');
Route::post('prodi', 'ProdiController@store');
Route::get('prodi/{id}', 'ProdiController@show');
Route::post('prodi/update', 'ProdiController@update');
Route::delete('prodi/{id}', 'ProdiController@destroy');

Route::get('matkul', 'MatkulController@index');
Route::post('matkul', 'MatkulController@store');
Route::get('matkul/{id}', 'MatkulController@show');
Route::post('matkul/update', 'MatkulController@update');
Route::delete('matkul/{id}', 'MatkulController@destroy');

Route::get('mahasiswa', 'MahasiswaController@index');
Route::post('mahasiswa', 'MahasiswaController@store');
Route::get('mahasiswa/{id}', 'MahasiswaController@show');
Route::post('mahasiswa/update', 'MahasiswaController@update');
Route::delete('mahasiswa/{id}', 'MahasiswaController@destory');

ROute::get('nilai', 'NilaiController@index');
Route::post('nilai', 'NilaiController@store');
Route::get('nilai/{id}', 'NilaiController@show');
Route::post('nilai/update', 'NilaiController@update');
Route::delete('nilai/{id}', 'NilaiController@destory');

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found'
    ], 404);
});