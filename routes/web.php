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

/**
 * TESTING WITH ROUTE->VIEWS
 */
// Route::get('/projects', function () {
//     $projects = App\Project::all();

//     return view('projects.index', compact('projects'));
// });

// Route::post('/projects', function () {
//     //validate

//     //presist
//     App\Project::create(request(['title', 'description']));

//     //redirect
// });



/**
 * TESTING WITH ROUTE->CONTROLLER
 */
Route::get('/projects', 'ProjectsController@index');
Route::get('/projects/{project}', 'ProjectsController@show');
Route::post('/projects', 'ProjectsController@store')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
