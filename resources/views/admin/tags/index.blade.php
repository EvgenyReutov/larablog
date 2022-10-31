@extends('layouts.base')

@section('content')

    <h2><a href="{{ route('admin.tags.create') }}">create a tag</a> </h2>
    @if (session()->has('alertType'))
        <div class="alert alert-{{ session('alertType') }}">{{ session('alertText') }}</div>
    @endif
<?php
//
//
?>

    <ul>
        @foreach($items as $item)
            <li>{{ $item->title }} <a href="{{ route('admin.tags.edit', ['tag' => $item->id]) }}">edit</a></li>
        @endforeach
    </ul>
@endsection
