@extends('layouts.base')

@section('content')

   <h2>Post detail page</h2>

    <p>ID - {{ $post->id }}</p>
    <p>Title - {{ $post->title }}</p>
    <p>Author - {{ $post->author->name }}</p>
    <p>Text - {{ $post->text }}</p>
    <p>Status - {{ $post->status->value }}</p>
@endsection
