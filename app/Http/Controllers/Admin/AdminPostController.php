<?php

namespace App\Http\Controllers\Admin;

use App\DTO\PostDTO;
use App\Http\Controllers\Controller;
use App\Enums\PostStatus;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Repo\Post\PostRepo;
use App\Repo\Post\PostEloquentRepo;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class AdminPostController extends Controller
{
    public function __construct(public PostRepo $postEloquentRepo) {
        $this->authorizeResource(Post::class, 'post');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(PostRepo $postRepo)
    {
        $posts = $postRepo->all();


        return view('admin.posts.index', compact('posts'));
        //return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create', [
            'tags' => Tag::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostStoreRequest $postStoreRequest, PostService $postService)
    {

        //dd($request->all());

        /*if (empty($request->get('title'))) {
            Session::flash('alertText', 'title error');
            Session::flash('alertType', 'danger');
            return redirect()->back()->withInput($request->all());
        }*/
        $arr = PostDTO::fromRequest($postStoreRequest);

        $post = $postService->create($arr);
        /*$post = Post::create($request->only([
            'title', 'text', 'author_id',
            'status',
            'slug'
        ]));*/

        Session::flash('alertType', 'success');
        Session::flash('alertText', "Post with id {$post->id} was created");
        return redirect()->back();
    }

    public function withoutRepo(Post $post)
    {
        //$post = $postEloquentRepo->findById($postId);
        dd(Route::current());
        dump($post);
        return '';
    }

    /**
     * Display the specified resource.
     *
     */
    public function show(int $postId)
    {
        $post = $this->postEloquentRepo->findById($postId);
        $tags = Tag::get();
        //dump($tags);
        //dump($post);
        return view('posts.show', compact('post', 'tags'));
    }/*
    public function show(Post $post)
    {
        //dd($post);
        return view('posts.show', compact('post'));
    }
*/
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(int $postId, PostRepo $postEloquentRepo)
    {
        $post = $postEloquentRepo->findById($postId);
        //dd($post);
        $tags = Tag::get();
        //dump($tags);
        //dd($post);
        return view('admin.posts.edit', compact('post', 'tags'));
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
        /*if (empty($request->get('title'))) {
            Session::flash('alertText', 'title error');
            Session::flash('alertType', 'danger');
            return redirect()->back()->withInput($request->all());
        }*/

        //$post->status = PostStatus::from($request->status);
        //$post->save();
        /*
        $post->update($request->only([
            'title', 'text', 'author_id',
            'status',
            'slug'
        ]));
        */
        //dd($postUpdateRequest->input('tags'));

        $authorId = $postUpdateRequest->validated('author_id');

        $post->tags()->detach();
        if ($postUpdateRequest->input('tags')) {
            $post->tags()->attach($postUpdateRequest->input('tags'));
        }

        $postService->update($post->id, PostDTO::fromRequest($postUpdateRequest));

        Cache::tags(['post_list', 'post_list_nav'])->flush();

        Session::flash('alertType', 'success');
        Session::flash('alertText', "Post with id {$post->id} was updated");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->tags()->detach();
        Session::flash('alertType', 'success');
        Session::flash('alertText', "Post with id {$post->id} was deleted");
        $post->delete();

        Cache::tags(['post_list', 'post_list_nav'])->flush();

        return redirect()->route('admin.posts.index');
    }
}
