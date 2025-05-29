@extends('layouts.master')

@section('content')
<div class="container">
    <h2>Create Professor</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('professors.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Professor Name</label>
            <input type="text" name="name" class="form-control" required placeholder="e.g. Dr. John Doe">
        </div>

        <div class="form-group mb-3">
            <label for="email">Professor Email</label>
            <input type="email" name="email" class="form-control" required placeholder="e.g. john.doe@example.com">
        </div>

        <button type="submit" class="btn btn-primary">Create Professor</button>
    </form>
</div>
@endsection
