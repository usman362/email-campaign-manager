@extends('layouts.master')

@section('content')
    <div class="container">
        <h2>Update Email Settings</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('settings.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Gmail Username</label>
                <input type="text" name="gmail_username" value="{{@$user->gmail_username}}" class="form-control" autocomplete="off" required placeholder="e.g. John Doe">
            </div>

            <div class="form-group mb-3">
                <label for="subject">Gmail Email</label>
                <input type="text" name="gmail_email" value="{{@$user->gmail_email}}" class="form-control" autocomplete="off" required placeholder="e.g. example@gmail.com">
            </div>

            <div class="form-group mb-3">
                <label for="body">Gmail Password</label>
                <input type="text" name="gmail_password" value="{{@$user->gmail_password}}" class="form-control" autocomplete="off" required placeholder="e.g. rxxx uxxx lxxx rxxx">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
