@extends('layouts.app')

@section('content')
    <h1>Edit Landing Page: {{ $landingPage->name }}</h1>

    <iframe src="{{ route('landing-pages.editor', $landingPage->id) }}" style="width: 100%; height: 80vh; border: none;"></iframe>
@endsection
