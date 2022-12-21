@extends('layouts.base')

@section('content')

   <h1>{{ $post->title }}</h1>
    <div data-post-id="{{ $post->id }}">
        {!! $post->text !!}
    </div>

   @php
       $tags = $post->tags->pluck('tags.title', 'code');
   @endphp

   @if (count($tags))
       <p>Теги -
       @foreach($tags as $key => $tag)
           <a href="{{ route('list_by_tag', ['tag' => $key]) }}">{{ $tag }}
           </a>@if (!$loop->last),@endif
       @endforeach
       </p>
   @endif
@endsection
