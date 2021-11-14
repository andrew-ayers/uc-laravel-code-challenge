<?php

use App\Address;
use App\Car;
use App\Owner;

use Illuminate\Support\Facades\Route;

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

Route::get('owner', 'OwnerController@index');
Route::get('owner/{owner}', 'OwnerController@show');
Route::get('owner/address/{address}', 'OwnerController@showOwnerForAddress');
Route::get('owner/car/{car}', 'OwnerController@showOwnerForCar');
Route::post('owner', 'OwnerController@store');
Route::put('owner/{owner}', 'OwnerController@update');
Route::delete('owner/{owner}', 'OwnerController@delete');

Route::get('address', 'AddressController@index');
Route::get('address/{address}', 'AddressController@show');
Route::get('address/owner/{owner}', 'AddressController@showAddressesForOwner');
Route::get('address/car/{car}', 'AddressController@showAddressForCar');
Route::post('address', 'AddressController@store');
Route::put('address/{address}', 'AddressController@update');
Route::delete('address/{address}', 'AddressController@delete');

Route::get('car', 'CarController@index');
Route::get('car/{car}', 'CarController@show');
Route::get('car/owner/{owner}', 'CarController@showCarsForOwner');
Route::get('car/address/{address}', 'CarController@showCarsForAddress');
Route::post('car', 'CarController@store');
Route::put('car/{car}', 'CarController@update');
Route::delete('car/{car}', 'CarController@delete');

Route::get('averages/owner', 'OwnerController@getOwnerAverages');
Route::get('averages/address', 'AddressController@getAddressAverages');

Route::get('{any}', function () {
    return view('layouts.app');
})->where('any', '.*');
