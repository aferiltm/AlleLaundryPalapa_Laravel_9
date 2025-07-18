@extends('auth.main')

@section('title', config('app.name') . ' - ' . __('auth.reg_title'))

@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card bg-light o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-5">
                        <h3 class="text-center mb-3">@lang('auth.reg_title')</h3>
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
                            <div class="form-group">
                                <label for="name">@lang('auth.name_label')</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="@lang('auth.name_placeholder')"
                                    value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">@lang('auth.email_label')</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="@lang('auth.email_placeholder')"
                                    value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone_number">No. Telpon/HP</label>
                                <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                                    id="phone_number" name="phone_number" placeholder="Masukkan No.Telpon/HP"
                                    value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('auth.password_label')</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="@lang('auth.password_placeholder')" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password2">@lang('auth.confirm_password_label')</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password2" name="password_confirmation" placeholder="@lang('auth.confirm_password_placeholder')" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button class="btn btn-success btn-block" type="submit">@lang('auth.reg_title')</button>
                        </form>
                        <hr>
                        <div class="text-center pt-3">
                            <p>Sudah memiliki akun? <a class="text-blue-500"
                                    href="{{ url('login') }}">@lang('auth.login_link')</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
