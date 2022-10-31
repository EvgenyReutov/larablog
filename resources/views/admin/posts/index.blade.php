@extends('layouts.base')

@section('content')

    <h2><a href="{{ route('admin.posts.create') }}">create a post</a> </h2>
<?php
//
//
?>

    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a> <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">edit</a></li>
        @endforeach
    </ul>
@endsection
