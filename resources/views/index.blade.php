@extends('layouts.base')


@section('content')
    <h1>it works content</h1>
@endsection


@section('title', $title)



@section('head-end')
    @parent
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endsection
