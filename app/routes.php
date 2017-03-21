<?php


$app->get('/articles[/{id}]', 'ArticleController:get')->setName('article.get');

$app->post('/articles[/{id}]', 'ArticleController:post')->setName('article.post');

$app->put('/articles[/{id}]', 'ArticleController:put')->setName('article.put');

$app->delete('/articles[/{id}]', 'ArticleController:delete')->setName('article.delete');

