<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title')</title>
    {{-- <link href="{{ asset('/img/dashboard/favicon.png') }}" rel="icon" type="image/png"> --}}
    <link rel="icon" type="image/png" href="https://laravel.com/img/favicon/favicon.ico">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Google Font: Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    style="background-color: rgb(37 99 235 / var(--tw-bg-opacity, 1)); background-repeat: no-repeat; background-position: center; background-size: cover;">

    <div class="w-full bg-white pt-3 -mt-24">
        <div x-data="{ open: false }"
            class="flex flex-col max-w-screen-xl px-4 mx-auto md:items-center md:justify-between md:flex-row md:px-6 lg:px-8">
            <div class="-mt-4 flex flex-row items-center justify-between">
                <a href="#"
                    class="text-lg font-semibold tracking-widest text-blue-600 uppercase rounded-lg focus:outline-none focus:shadow-outline">KANTIL
                    LAUNDRY</a>
                <button class="md:hidden rounded-lg focus:outline-none focus:shadow-outline" @click="open = !open">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="w-6 h-6">
                        <path x-show="!open" fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                        <path x-show="open" fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <nav :class="{ 'flex': open, 'hidden': !open }"
                class="flex-col flex-grow pb-4 md:pb-0 hidden md:flex md:justify-end md:flex-row">
                <a class="px-4 py-2 mt-2 text-sm font-semibold rounded-lg md:mt-0 md:ml-4 text-white hover:text-gray-900 focus:text-gray-900 bg-blue-900 hover:bg-sky-600 focus:bg-gray-200 focus:outline-none focus:shadow-outline"
                    href="/">Kembali</a>
            </nav>
        </div>
    </div>

    {{-- <nav class="navbar navbar-expand-sm navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item mr-sm-3 mb-2 mb-sm-0">
                        <a class="btn btn-success" href="/">Kembali</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> --}}

    @yield('container')

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/js/adminlte.js') }}"></script>

</body>

</html>
