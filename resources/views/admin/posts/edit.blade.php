@extends('layouts.base')

@section('content')
    <h2>Редактирование поста с ID - {{ $post->id }}</h2>
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
        $tagsIds = $post->tags->pluck('tags.id')->toArray();

    @endphp
    <form action="{{ route('admin.posts.update', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('PUT')
        <p>
            Tags:<br>
        @foreach ($tags as $tag)

            <label><input type="checkbox" name="tags[]" value="{{ $tag->id }}"
        @if (in_array($tag->id, $tagsIds))
            checked="checked"
        @endif

            >{{ $tag->title }}</label><br>

        @endforeach
        </p>
        <p>Title - <input type="text" name="title" size="40" value="{{ old('title', $post->title) }}"></p>
        <p>Slug - <input type="text" name="slug" size="40" value="{{ old('slug', $post->slug) }}"></p>
        <p>Author Id - <input type="number" name="author_id" required value="{{ old('author_id', $post->author->id) }}"></p>
        <p>Text<br>
            <textarea cols="60" rows="15" name="text" required >{{ old('text', $post->text) }}</textarea></p>
        <p>Status -
            <select name="status" >
                @foreach($statuses as $value => $status)
                    <option value="{{ $value }}"
                            @if (old('status', $post->status->value) === $value)selected @endif
                    >{{ $status }}</option>
                @endforeach
            </select>
        </p>
        <button class="btn btn-primary">Update</button>
    </form>
    <br>
    <form action="{{ route('admin.posts.destroy', ['post' => $post->id]) }}" method="post">
        @csrf
        @method('DELETE')
        <label>Удаление <button type="submit" class="btn btn-danger">Delete</button></label>
    </form>
    <a href="{{ route('admin.posts.index') }}">Перейти к списку</a>
@endsection
