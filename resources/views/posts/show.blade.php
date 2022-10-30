@extends('layouts.base')

@section('content')

    <p><a href="{{ route('posts.edit', ['post' => $post->id]) }}">Edit post</p>
    <br><br>

    <p>ID - {{ $post->id }}</p>
    <p>Title - {{ $post->title }}</p>
    <p>Author - {{ $post->author->name }}</p>
    <p>Text - {{ $post->text }}</p>
    <p>Status - {{ $post->status->value }}</p>
@endsection
