@extends('layouts.app')

@section('content')
    <h1>Landing Pages</h1>

    <a href="{{ route('landing-pages.create') }}">Create Landing Page</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($landingPages as $page)
                <tr>
                    <td>{{ $page->name }}</td>
                    <td>{{ $page->slug }}</td>
                    <td>
                        <a href="{{ route('landing-pages.edit', $page->id) }}">Edit</a>
                        <a href="{{ route('landing-pages.public', $page->slug) }}" target="_blank">View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
