<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Article;
use Illuminate\Http\Request;
use App\Http\Resources\Article as ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get articles
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);

        // return the collection of articles as a resource
        // the collection function is as stated in the docs that if youre returning a list of resources you should use
        return ArticleResource::collection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $article = $request->isMethod('put') ? Article::findorFail($request->article_id) : new Article;
        $article->id = $request->input('article_id');
        $article->title = $request->input('title');
        $article->body = $request->input('body');

        if($article->save()) {
            return new ArticleResource($article);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get a single artcile
        $article = Article::findorFail($id);

        // return the single article as a resource
        return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function destroy($id)
    {
         // get a single artcile
         $article = Article::findorFail($id);

         if($article->delete()){
            return new ArticleResource($article);
        }
}
}
