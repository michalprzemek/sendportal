@extends('layouts.app')

@section('content')
    <h1>Create Landing Page</h1>

    <form action="{{ route('landing-pages.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </div>

        <div>
            <label for="slug">Slug</label>
            <input type="text" name="slug" id="slug">
        </div>

        <button type="submit">Create and Open Editor</button>
    </form>
@endsection
