<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;


Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    // $router->resource('config', 'ConfigController');
    // $router->resource('message', 'MessageController');
    $router->resource('article', 'ArticleController');
    $router->resource('category', 'CategoryController');
    $router->resource('tags', 'TagController');
    $router->resource('comment', 'ArticleCommentController');
    
    // $router->resource('set_config', 'SetConfigController');


});
