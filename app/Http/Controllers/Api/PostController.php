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
    public const PAGE_SIZE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return PostsResource
     */
    public function index()
    {
        $posts = Post::paginate(self::PAGE_SIZE);

        return new PostsResource($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @param  PostStoreRequest  $postStoreRequest
     * @param  PostService  $postService
     *
     * @return array[]
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
     * @param  int  $postId
     *
     * @return array
     */
    public function show(int $postId)
    {
        $post = Post::findOrFail($postId);
        return ['data' => $post];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostUpdateRequest  $postUpdateRequest
     * @param  Post  $post
     * @param  PostService  $postService
     *
     * @return array[]
     */
    public function update(PostUpdateRequest $postUpdateRequest, Post $post, PostService $postService)
    {
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
     * @param  Post  $post
     *
     * @return array[]
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
