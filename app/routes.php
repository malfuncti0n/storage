<?php

//one route will dynamicly calculate the correct method based on method
$app->any('/api/user[/{id}[/{password}]]', 'UserController:getCall');



