@extends('layouts.base')

@section('content')
<style>
.date {
    margin-bottom: 10px;
}
</style>
   <h1>{{ $post->title }}</h1>
    <div data-post-id="{{ $post->id }}">
        <div class="date badge bg-dark">{{ $post->created_at->format('d/m/Y') }}</div>
        <div>
        {!! $post->text !!}
        </div>
    </div>

    @php
        $tags = $post->tags->pluck('tags.title', 'code');
        $tagClasses = [
            'bg-secondary',
            'bg-success',
            'text-bg-info',
            'bg-danger',
            'text-bg-warning',
            'bg-primary',
            'text-bg-light',
            'bg-dark'
        ];
    @endphp

   @if (count($tags))
       <p>Теги -
       @foreach($tags as $key => $tag)
           <a class="badge rounded-pill {{ $tagClasses[$loop->index] }}" href="{{ route('list_by_tag', ['tag' => $key]) }}">{{ $tag }}
           </a>@if (!$loop->last),@endif
       @endforeach
       </p>
   @endif
@endsection
