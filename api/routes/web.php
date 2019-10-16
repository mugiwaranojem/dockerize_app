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

$router->get('/register/me', 'AuthController@me');


$router->post('/login', 'AuthController@postLogin');
$router->post('/register', 'RegisterController@postRegister');

$router->get('/topic', 'TopicsController@getTopics');
$router->post('/topic', 'TopicsController@postTopic');
$router->patch('/topic/{id}', 'TopicsController@updateTopic');
$router->post('/topic/{id}', 'TopicsController@updateTopic');
$router->post('/topic/{id}/delete', 'TopicsController@deleteTopic');
$router->delete('/topic/{id}', 'TopicsController@deleteTopic');

$router->post('/topic/{id}/message', 'TopicsController@addMessageToTopic');
$router->get('/topic/{id}/messages', 'TopicsController@getMessages');




