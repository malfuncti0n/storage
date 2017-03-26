<?php

//split routes because javascript front end fails with options
$app->get('/users/{username}/{password}', 'UserController:get');
$app->post('/users', 'UserController:post');
$app->put('/users[/{id}]', 'UserController:put');
$app->delete('/users[/{id}]', 'UserController:delete');



