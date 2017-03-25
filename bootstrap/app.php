<?php
header('Access-Control-Allow-Origin: *');
//composer autoload
require __DIR__ . '/../vendor/autoload.php';

//configuration values
use Noodlehaus\Config;

$config = new Config(__DIR__ . '/../app/config');

$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true,
        'db' => [
            'driver' => $config->get('mysql.driver'),
            'host' => $config->get('mysql.host'),
            'database'  => $config->get('mysql.database'),
            'username'  => $config->get('mysql.username'),
            'password'  => $config->get('mysql.password'),
            'charset'   => $config->get('mysql.charset'),
            'collation' => $config->get('mysql.collation'),
            'prefix'    => $config->get('mysql.prefix'),
        ],
        'determineRouteBeforeAppMiddleware' => true
    ],
]);


$container = $app->getContainer();
//database connections

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$container['db'] = function ($container) use ($capsule){
};

$container['UserController'] = function ($container){
    return new \App\Controllers\UserController($container);
};


//midleware to change content type in all
//$app->add(new \App\Middleware\JsonResponseMiddleware);

require __DIR__ . '/../app/routes.php';
