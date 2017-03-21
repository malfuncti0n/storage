<?php

namespace App\Controllers;

use App\Models\Article;

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
            return $this->response->withStatus(404);
        }

        //else get response body and send response in json format
        $body = $response->getBody();
        $body->write(json_encode($articleBody));
        return $this->response->withBody($body);
    }


    public function post(){
        die('post');
    }

    public function put($id){
        die($id);
    }

    public function delete($id){
        die($id);
    }
}
