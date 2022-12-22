@extends('layouts.base')

@php
//, 'locale' => App::getLocale()
@endphp
@section('content')

    <h1 class="h1">{{ __('post_list') }} </h1>

    @if ($tag)
        <span>Выбранный тег - <span class="badge rounded-pill bg-secondary">{{ $tag }}</span></p>
    @endif


    <ul class="icon-list ps-0">
        @foreach($posts as $post)
            <li class="d-flex align-items-start mb-1">
                <a href="{{ route('posts.show', ['post' => $post->slug]) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>

    {{ $posts->links('../blocks/paginate') }}
@endsection

@section('head-end')
    @parent
    <link href="/assets/css/starter-template.css" rel="stylesheet">
@endsection
