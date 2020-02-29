<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('profiles[/{id}]', 'ProfilesController@show');
$router->group(['prefix' => 'profiles'], function ($router) {
    $router->post('/', 'ProfilesController@store');
    $router->put('/{id}', 'ProfilesController@update');
    $router->delete('/{id}', 'ProfilesController@delete');
    $router->post('/activate/{id}', 'ProfilesController@activate');
});



