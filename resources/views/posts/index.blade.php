@extends('layouts.base')

@section('content')

    <h2><a href="{{ route('posts.create') }}">create post</a> </h2>


    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a></li>
        @endforeach
    </ul>
@endsection
