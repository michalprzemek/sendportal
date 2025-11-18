@extends('layouts.app')

@section('content')
    <h1>Automations</h1>

    <a href="{{ route('automations.create') }}">Create Automation</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($automations as $automation)
                <tr>
                    <td>{{ $automation->name }}</td>
                    <td>
                        <a href="{{ route('automations.edit', $automation->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
