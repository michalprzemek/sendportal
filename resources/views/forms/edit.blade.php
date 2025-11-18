@extends('layouts.app')

@section('content')
    <h1>Edit Subscription Form</h1>

    <form action="{{ route('forms.update', $form->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $form->name }}">
        </div>

        <div>
            <label for="subscriber_list_id">Subscriber List</label>
            <select name="subscriber_list_id" id="subscriber_list_id">
                @foreach ($subscriberLists as $list)
                    <option value="{{ $list->id }}" {{ $form->subscriber_list_id == $list->id ? 'selected' : '' }}>{{ $list->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="redirect_after_subscribe_url">Redirect URL after subscription</label>
            <input type="text" name="redirect_after_subscribe_url" id="redirect_after_subscribe_url" value="{{ $form->redirect_after_subscribe_url }}">
        </div>

        <div>
            <label for="redirect_after_confirm_url">Redirect URL after confirmation</label>
            <input type="text" name="redirect_after_confirm_url" id="redirect_after_confirm_url" value="{{ $form->redirect_after_confirm_url }}">
        </div>

        <div>
            <label for="welcome_email_template_id">Welcome Email Template</label>
            <select name="welcome_email_template_id" id="welcome_email_template_id">
                <option value="">-- None --</option>
                @foreach ($templates as $template)
                    <option value="{{ $template->id }}" {{ $form->welcome_email_template_id == $template->id ? 'selected' : '' }}>{{ $template->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>
                <input type="checkbox" name="is_captcha_enabled" value="1" {{ $form->is_captcha_enabled ? 'checked' : '' }}>
                Enable reCAPTCHA
            </label>
        </div>

        <button type="submit">Save Changes</button>
    </form>

    <h2>Embed Code</h2>
    <textarea readonly cols="80" rows="10">{{ $form->html_content }}</textarea>
@endsection
