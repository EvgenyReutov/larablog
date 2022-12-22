@extends('layouts.base')


@section('content')
    <h1>it works content</h1>

    <h2>{{ __('index.hello', ['name' => 'Ivan']) }}</h2>

    <ol>
    @foreach($users as $user)

        <li class="@if ($loop->even) even @else odd @endif">{{ $user }}</li>
    @endforeach
    </ol>
@endsection


@section('title', $title)



@section('head-end')
    @parent
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection
