@extends('layouts.base')

@section('content')

    <h2>{{ __('post_list') }} </h2>


    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['post' => $post->id, 'locale' => App::getLocale()]) }}">{{ $post->title }}</a></li>
        @endforeach
    </ul>
@endsection
