<?php

namespace App\Http\Controllers;

use App\DTO\PostDTO;
use App\Models\Tag;
use App\Providers\AuthServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize(AuthServiceProvider::ADMINS);


        $items = Tag::all();

        return view('admin.tags.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize(AuthServiceProvider::ADMINS);
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize(AuthServiceProvider::ADMINS);
        $tag = Tag::create($request->only([
            'title'
        ]));

        Session::flash('alertType', 'success');
        Session::flash('alertText', "Tag with id {$tag->id} was created");
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        Gate::authorize(AuthServiceProvider::ADMINS);
        //$tag = $tagEloquentRepo->findById($tagId);
        //dd($tag);
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        Gate::authorize(AuthServiceProvider::ADMINS);
        $tag->update($request->only([
            'title'
        ]));

        Session::flash('alertType', 'success');
        Session::flash('alertText', "Tag with id {$tag->id} was updated");
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize(AuthServiceProvider::ADMINS);
        Session::flash('alertType', 'success');
        Session::flash('alertText', "Tag with id {$tag->id} was deleted");
        $tag->delete();
        return redirect()->route('admin.tags.index');
    }
}
