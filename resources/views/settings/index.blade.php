@extends('layouts.master')

@section('content')
    <div class="card">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4>Email Templates</h4>
            <a href="{{ route('settings.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Email Setting
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $user->gmail_username }}</td>
                        <td>{{ $user->gmail_email }}</td>
                        <td>{{ $user->gmail_password }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
