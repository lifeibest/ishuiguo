<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resources([
        'organization' => OrganizationController::class,
        'categories' => CategoryController::class,
        'systemconfig-type' => SystemconfigTypeController::class,
        'systemconfig' => SystemconfigController::class,

    ]);

});
