<?php

namespace App\Controllers;

use App\Models\Article;

use App\Presenters\ArticlePresenter;

class ArticleController extends Controller
{

    public function get($request, $response)
    {
        //get article id
        $routeParams = $request->getAttribute('routeInfo')[2];
        //find in database
        $article=new Article;
        $articleBody=$article->find($routeParams['id']);

        //if article not found redirect back with 404 status
        if(!$articleBody){
            return $this->fastResponse(null,404);
        }
        //else get response body and send response in json format
        return $this->fastResponse((new ArticlePresenter($articleBody))->present(), 200, $response);
    }


    public function post($request, $response){
        $json = $this->request->getBody();
        $data = json_decode($json, true);
        $article = new Article;
        $article->title=$data['title'];
        $article->body=$data['body'];
        $article->save();
        return $this->fastResponse((new ArticlePresenter($article))->present(), 200, $response);

    }

    public function put($request, $response){
       die('put');
    }

    public function delete($request, $response){
        die('delete');
    }
}
