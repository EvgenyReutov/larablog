@extends('layouts.base')

@section('content')
    <p>ID - {{ $post->id }}</p>
    <p>Title - {{ $post->title }}</p>
    <p>Author - {{ $post->autor->name }}</p>
    <p>Text - {{ $post->text }}</p>
@endsection
