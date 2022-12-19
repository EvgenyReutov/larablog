@extends('layouts.base')

@section('content')

   <h1>{{ $post->title }}</h1>
    <div data-post-id="{{ $post->id }}">
        {!! $post->text !!}
    </div>


@endsection
