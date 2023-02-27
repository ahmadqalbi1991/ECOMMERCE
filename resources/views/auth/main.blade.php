<!DOCTYPE html>
<html lang="en">
@include('partial.head')
@php
    $setting = \App\Models\Setting::first();
@endphp
<body>
<div id="auth">
    <div class="row h-100">
        <div class="col-lg-6 col-12">
            <div id="auth-left">
                <div class="auth-logo">
                    @if($setting)
                        <a href=""><img src="{{ asset($setting->logo) }}" alt="Logo"></a>
                    @else
                        <a href=""><img src="{{ asset($setting->logo) }}" alt="Logo"></a>
                    @endif
                </div>
                <h1 class="auth-title">Log in.</h1>
                <p class="auth-subtitle">Log in with your data that you entered during registration.</p>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email"
                               class="form-control form-control-xl @error('email') is-invalid @enderror"
                               placeholder="Username / Email">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password"
                               class="form-control form-control-xl @error('password') is-invalid @enderror"
                               placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                </form>
            </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block">
            <div id="auth-right">
                <img src="{{ asset('assets/images/svgs/login.svg') }}" alt="">
            </div>
        </div>
    </div>

</div>
</body>

</html>
