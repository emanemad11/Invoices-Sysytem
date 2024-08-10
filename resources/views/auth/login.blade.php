@extends('layouts.master2')

@section('title', 'تسجيل دخول - برنامج الفواتير')

@section('css')
<!-- Sidemenu-responsive-tabs css -->
<link href="{{ URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css') }}"
    rel="stylesheet">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .login-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f4f7;
    }

    .login-form {
        background-color: white;
        padding: 2rem;
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 400px;
    }

    .login-form h2,
    .login-form h5 {
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-form text-center">
        <div class="mb-4">
            <a href="{{ url('/' . $page='Home') }}">
                <img src="{{ URL::asset('assets/img/brand/favicon.png') }}" class="mb-3" alt="logo"
                    style="height: 40px;">
            </a>
            <h1 class="main-logo1">Mora<span>So</span>ft</h1>
        </div>
        <div>
            <h2>مرحبا بك</h2>
            <h5 class="font-weight-semibold mb-4">تسجيل الدخول</h5>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group mb-3 text-start">
                    <label for="email">البريد الالكتروني</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group mb-3 text-start">
                    <label for="password">كلمة المرور</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-check mb-3 text-start">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember')
                        ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('تذكرني') }}
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    {{ __('تسجيل الدخول') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
