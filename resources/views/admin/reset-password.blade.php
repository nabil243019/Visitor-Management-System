@extends('layouts.admin-guest')

@section('content')
<div class="login-box">

    <h4>Reset Password</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                value="{{ old('email', $email) }}"
                required
                autofocus
            >
        </div>

        <div class="form-group mb-3">
            <label for="password">Password Baru</label>
            <input
                type="password"
                name="password"
                id="password"
                class="form-control"
                required
            >
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Reset Password
        </button>

    </form>

</div>
@endsection
