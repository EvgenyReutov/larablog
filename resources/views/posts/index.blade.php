@extends('layouts.base')

@php
//, 'locale' => App::getLocale()
@endphp
@section('content')

    <h2>{{ __('post_list') }} </h2>

    @if ($tag)
        <p>Выбранный тег - {{ $tag }}</p>
    @endif


    <ul>
        @foreach($posts as $post)
            <li><a href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a></li>
        @endforeach
    </ul>

    {{ $posts->links('../blocks/paginate') }}
@endsection
