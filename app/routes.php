<?php

//split routes because javascript front end fails with options
$app->get('/users[/{id}]', 'UserController:get');
$app->post('/users[/{id}]', 'UserController:post');
$app->put('/users[/{id}]', 'UserController:put');
$app->delete('/users[/{id}]', 'UserController:delete');



