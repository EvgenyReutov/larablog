@extends('layouts.root')


@section('body')
    <form action="{{ route('calculate') }}" method="post">
        @csrf
        <input type="text" name="x1" value=""><br><br>
        <input type="text" name="x2" value=""><br><br>
<button>calc</button>
    </form>
@endsection
