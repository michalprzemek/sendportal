@extends('layouts.app')

@section('content')
    <h1>Edit Automation</h1>

    <form action="{{ route('automations.update', $automation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $automation->name }}">
        </div>

        <button type="submit">Save</button>
    </form>

    <h2>Automation Emails</h2>
    @livewire('automation-emails', ['automation' => $automation])
@endsection
