<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy("created_at","desc")->get();
        
        if ($posts->isEmpty()) {
            return response()->json([
                "error"=> "",
                "message" => "No data available",
                ], Response::HTTP_OK);
        }else{
            return PostResource::collection($posts);
        }   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validatedData = $request->validated();
        $post = Post::create($validatedData);

        return response()->json([
            "error"=> "false",
            "message"=> "Post created successfully",
            "data" => new PostResource($post),
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $validatedData = $request->validated();

        $post->update($validatedData);

        return response()->json([
            "error"=> "false",
            "message"=> "Post Updated successfully",
            "data" => new PostResource($post),
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([
            "status"=> "success",
            "message"=> "Deleted!"
          ], Response::HTTP_OK);
    }
}
