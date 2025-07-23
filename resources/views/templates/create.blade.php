@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Create Email Template</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('templates.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Template Name</label>
            <input type="text" name="name" class="form-control" autocomplete="off" required placeholder="e.g. Welcome Email">
        </div>

        <div class="form-group mb-3">
            <label for="subject">Email Subject</label>
            <input type="text" name="subject" class="form-control" autocomplete="off" required>
        </div>

        <div class="form-group mb-3">
            <label for="body">Email Body</label>
            <textarea id="summernote" name="body"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Template</button>
    </form>
</div>
@endsection

