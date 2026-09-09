@extends('layouts.admin-guest')

@section('content')
<div class="login-box">

    <h4>Lupa Password</h4>
    <p>Masukkan email admin kamu, link reset password akan dikirim ke email tersebut.</p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                autofocus
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Kirim Link Reset
        </button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">Kembali ke Login</a>
        </div>

    </form>

</div>
@endsection
