<?php

namespace App\Http\Controllers\Admin;

use App\DTO\PostDTO;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminTagController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Tag::class, 'tag');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        $tag = Tag::create($request->only([
              'title', 'code'
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
        $tag->update($request->only([
                'title', 'code'
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
        Session::flash('alertType', 'success');
        Session::flash('alertText', "Tag with id {$tag->id} was deleted");
        $tag->delete();
        return redirect()->route('admin.tags.index');
    }
}
