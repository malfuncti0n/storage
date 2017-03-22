<?php

//one route for all api methods
$app->any('/articles[/{id}]', 'ArticleController:getCall');

