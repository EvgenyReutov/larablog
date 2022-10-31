@extends('layouts.base')

@section('content')
    <h2>tag edit form</h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session()->has('alertType'))
        <div class="alert alert-{{ session('alertType') }}">{{ session('alertText') }}</div>
    @endif

    <form action="{{ route('admin.tags.update', ['tag' => $tag->id]) }}" method="post">
        @csrf
        @method('PUT')
        <p>ID - {{ $tag->id }}</p>
        <p>Title - <input type="text" name="title" required value="{{ old('title', $tag->title) }}"></p>

        <button class="btn btn-primary">Update</button>
    </form>
    <br><br>
    <form action="{{ route('admin.tags.destroy', ['tag' => $tag->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endsection
