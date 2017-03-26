<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

require __DIR__ . '/../vendor/autoload.php';

//configuration values
use Noodlehaus\Config;
//validator
use Respect\Validation\Validator as v;


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

$container['validator'] = function ($container){
    return new App\Validation\Validator;
};

$container['UserController'] = function ($container){
    return new \App\Controllers\UserController($container);
};



//load valitation with custom rules
v::with('App\\Validation\\Rules\\');

//midleware to change content type in all
//$app->add(new \App\Middleware\JsonResponseMiddleware);

require __DIR__ . '/../app/routes.php';
