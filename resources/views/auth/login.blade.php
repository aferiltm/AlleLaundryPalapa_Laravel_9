@extends('auth.main')

{{-- @section('title', config('app.name') . ' - ' . __('auth.log_title')) --}}
@section('title', 'Alle Laundry Palapa - Login')

@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card bg-light o-hidden border-0 shadow-lg my-5 mx-auto">
                    <div class="card-body p-5">
                        {{-- <h3 class="text-center mb-3">@lang('auth.log_title')</h3> --}}
                        <div class="flex justify-center mb-4">
                            <a href="#">
                                <img src="{{ asset('img/dashboard/logo_alle.jpg') }}" class="w-40" alt="ENC Logo">
                            </a>
                        </div>
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (session('warning'))
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                {{ session('warning') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="" method="POST">
                            @csrf
                            {{-- <div class="form-group">
                                <label for="email">@lang('auth.email_label')</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="@lang('auth.email_placeholder')"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('auth.password_label')</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="@lang('auth.password_placeholder')">
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label for="login">Email atau Nomor Telepon</label>
                                <input type="text" name="login" class="form-control"
                                    placeholder="Masukkan email/no.telepon anda" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password anda" required>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">@lang('auth.remember_me')</label>
                            </div>
                            <button class="btn bg-blue-900 hover:bg-blue-950 btn-block text-white rounded-lg" type="submit">LOGIN</button>
                        </form>
                        <hr>
                        <div class="text-center mt-3">
                            <p>Belum Punya Akun? <a class="text-blue-800" href="{{ url('register') }}">Registrasi!</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
