@extends('layouts.base')

@section('content')
    <h2>Создать тэг</h2>

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

    <form action="{{ route('admin.tags.store') }}" method="post">
        @csrf

        <p>Title - <input type="text" name="title" required value="{{ old('title') }}"></p>
        <p>Code - <input type="text" name="code" required value="{{ old('code') }}"></p>

        <button>Create</button>
    </form>
@endsection
