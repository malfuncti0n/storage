<?php

//one route for all api methods
$app->any('/users[/{id}]', 'UserController:getCall');

