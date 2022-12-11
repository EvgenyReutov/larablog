<?php

namespace App\Http\Controllers\Api;

use App\DTO\PostDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsResource;
use App\Models\Post;
use App\Repo\Post\PostRepo;
use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostRepo $postRepo)
    {
        //$posts = $postRepo->all();
        $posts = Post::all();

        //return ['data' => $posts];
        //return PostResource::collection($posts);
        return new PostsResource($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PostStoreRequest $postStoreRequest, PostService $postService)
    {
        $arr = PostDTO::fromRequest($postStoreRequest);

        try {
            $post = $postService->create($arr);
            $data['result'] = 'success';
            $data['postId'] = $post->id;
        } catch (\Exception $e) {
            $data['result'] = 'error';
            $data['message'] = $e->getMessage();
        }

        return ['data' => $data];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post, PostRepo $postRepo)
    {
        //return new PostResource($post);
        return $postRepo->findById($post->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostUpdateRequest $postUpdateRequest, Post $post, PostService $postService)
    {
        $authorId = $postUpdateRequest->validated('author_id');
        $result = $postService->update($post->id, PostDTO::fromRequest($postUpdateRequest));

        $data['result'] = 'error';
        if ($result) {
            $data['result'] = 'success';
        }


        return ['data' => $data];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            $post->delete();
            $data['result'] = 'success';
        } catch (\Exception $e) {
            $data['result'] = 'error';
            $data['message'] = $e->getMessage();
        }
        return ['data' => $data];
    }
}
