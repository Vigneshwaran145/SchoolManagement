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
Route::resource('materialClass', 'MaterialClassMapController');
Route::resource('teachers', 'TeacherController');
Route::resource('students', 'StudentController');
Route::resource('classes', 'ClassMapController');
Route::resource('materials', 'MaterialController');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/fetchTeacher', 'AjaxController@fetchTeacher')->name('fetchTeacher');
Route::get('/fetchSubject', 'AjaxController@fetchSubject')->name('fetchSubject');
Auth::routes();
Route::get('/fetchSubForAssigning', 'AjaxController@fetchSubForAssigning')->name('fetchSubForAssigning');
Route::get('/fetchMaterials', 'AjaxController@fetchMaterials')->name('fetchMaterials');
Route::get('/fetchSubForMaterial', 'AjaxController@fetchSubForMaterial')->name('fetchSubForMaterial');
Route::get('/fetchSection', 'AjaxController@fetchSection')->name('fetchSection');
Route::get('/fetchTeachersClass', 'AjaxController@fetchTeachersClass')->name('fetchTeachersClass');
Route::get('/fetchSubByClass', 'AjaxController@fetchSubByClass')->name('fetchSubByClass');
Route::get('/home', 'HomeController@index')->name('home');
