@extends('layouts.base')

@section('content')

    <h2><a href="{{ route('admin.posts.create') }}">Создать пост</a></h2>
<?php
//
//
?>

    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a> <a href="{{ route('admin.posts.edit', ['post' => $post->id]) }}">редактировать</a>
                ({{ $post->tags->pluck('title')->implode(', ') }})
            </li>
        @endforeach
    </ul>
@endsection
