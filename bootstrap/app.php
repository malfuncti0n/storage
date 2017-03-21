<?php

require __DIR__ . '/../vendor/autoload.php';


$container = new \Slim\Container;


$app = new \App\App($container);


require __DIR__ . '/../app/routes.php';
