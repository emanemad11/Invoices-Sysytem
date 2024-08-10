<x-guest-layout>
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
                <h5 class="font-weight-semibold mb-4">تسجيل حساب جديد</h5>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="form-group mb-3 text-start">
                        <label for="name">الاسم</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="form-group mb-3 text-start">
                        <label for="email">البريد الالكتروني</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3 text-start">
                        <label for="password">كلمة المرور</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-3 text-start">
                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                        <input id="password_confirmation" type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group mb-3 text-start">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
