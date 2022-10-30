@extends('layouts.base')

@section('content')
    <h2>post create form</h2>

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

    @php
    $statuses = ['active' => 'Active', 'draft' => 'Draft'];
    @endphp
    <form action="{{ route('posts.store') }}" method="post">
        @csrf

        <p>Title - <input type="text" name="title"  value="{{ old('title') }}"></p>
        <p>Slug - <input type="text" name="slug"  value="{{ old('slug') }}"></p>
        <p>Author Id - <input type="number" name="author_id" required value="{{ old('author_id') }}"></p>

        <p>Status -
            <select name="status" >
                @foreach($statuses as $value => $status)
                    <option value="{{ $value }}"
                        @if (old('status', 'draft') === $value)selected @endif
                    >{{ $status }}</option>
                @endforeach

            </select>
            </p>
        <p>Text<br><textarea rows="10" cols="80" name="text" required >{{ old('text') }}</textarea></p>

        <button>Create</button>
    </form>
@endsection
