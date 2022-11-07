<?php

namespace App\Http\Controllers;

use App\DTO\PostDTO;
use App\Enums\PostStatus;
use App\Http\Requests\Post\PostStoreRequest;
use App\Models\Post;
use App\Models\User;
use App\Repo\Post\PostRepo;
use App\Repo\Post\PostEloquentRepo;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function __construct(public PostRepo $postEloquentRepo) {

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(PostRepo $postRepo)
    {
        //$this->authorize('viewAny', Post::class);
        //dd($postRepo);
        $posts = $postRepo->all();

        return view('posts.index', compact('posts'));
        //return view('posts.index', ['posts' => $posts]);
    }


    /**
     * Display the specified resource.
     *
     */
    public function show(int $postId)
    {
        $post = $this->postEloquentRepo->findById($postId);
        //dump($post);
        return view('posts.show', compact('post'));
    }/*
    public function show(Post $post)
    {
        //dd($post);
        return view('posts.show', compact('post'));
    }
*/
}
