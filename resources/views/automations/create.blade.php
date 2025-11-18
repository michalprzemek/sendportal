@extends('layouts.app')

@section('content')
    <h1>Create Automation</h1>

    <form action="{{ route('automations.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name">
        </div>

        <div>
            <label for="subscriber_list_id">Subscriber List</label>
            <select name="subscriber_list_id" id="subscriber_list_id">
                @foreach ($subscriberLists as $list)
                    <option value="{{ $list->id }}">{{ $list->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit">Create</button>
    </form>
@endsection
