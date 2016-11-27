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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/room/add', 'HomeController@addRoomView');

Route::post('/add/rooms', 'HomeController@addRoom');

Route::get('/room/update', 'HomeController@updateRoomView');

Route::post('/update/rooms', 'HomeController@updateRoom');

Route::get('/available/rooms', 'HomeController@availRoomsView');

Route::get('/not_available/rooms', 'HomeController@busyRoomsView');

Route::get('/reservation/update', 'HomeController@resUpdateView');

Route::post('/update/reservation', 'HomeController@updateRes');

Route::post('/rooms', 'roomController@getRooms');

Route::post('/book','roomController@bookView');

Route::post('/res','roomController@book');


