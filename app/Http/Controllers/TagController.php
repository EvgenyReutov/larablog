<?php

namespace App\Http\Controllers;

use App\DTO\PostDTO;
use App\Models\Tag;
use Illuminate\Http\Request;
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
        $items = Tag::all();

        return view('admin.tags.index', ['items' => $items]);
    }


}
