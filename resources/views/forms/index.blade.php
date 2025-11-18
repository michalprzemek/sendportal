@extends('layouts.app')

@section('content')
    <h1>Subscription Forms</h1>

    <a href="{{ route('forms.create') }}">Create Form</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($forms as $form)
                <tr>
                    <td>{{ $form->name }}</td>
                    <td>
                        <a href="{{ route('forms.edit', $form->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
