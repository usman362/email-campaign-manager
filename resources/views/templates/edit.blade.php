@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Edit Email Template</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('templates.update', $template->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Template Name</label>
                <input type="text" name="name" class="form-control" value="{{ $template->name }}" required
                    placeholder="e.g. Welcome Email">
            </div>

            <div class="form-group mb-3">
                <label for="subject">Email Subject</label>
                <input type="text" name="subject" class="form-control" value="{{ $template->subject }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="body">Email Body</label>
                <textarea id="summernote" name="body">{{ $template->body }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Template</button>
        </form>
    </div>
@endsection
