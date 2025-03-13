@extends('layouts.auth-layout')

@section('content')
    <div class="login-box">
        <div class="login-logo">
            <span>Coffee Shop</span>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" email required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                </form>

                @error('email')
                    <p class="mt-3 text-danger text-center">{{ $message }}</p>
                @enderror
            </div>
        </div>
@endsection