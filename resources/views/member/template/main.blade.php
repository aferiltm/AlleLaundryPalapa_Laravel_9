<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>{{ config('app.name') }} - Member</title>
    {{-- <link href="{{ asset('/img/dashboard/favicon.png') }}" rel="icon" type="image/png"> --}}
    <link rel="icon" type="image/png" href="https://laravel.com/img/favicon/favicon.ico">

    {{-- Tailwind CSS --}}
    {{-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> --}}

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <!-- Google Font: Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/ba5dd8b181.js" crossorigin="anonymous"></script>
    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        @include('member.template.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 bg-cyan-600">
            <!-- Brand Logo -->
            <a href="" class="brand-link mt-2 text-white">
                {{-- <i class="fas fa-tshirt brand-image mt-1 ml-3"></i> --}}
                {{-- <h4 class="brand-text text-center">{{ config('app.name') }}</h4> --}}
                <h4 class="brand-text text-center">Alle Laundry Palapa</h4>
            </a>

            <!-- Sidebar -->
            @include('member.template.sidebar')
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            @yield('main-content')
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
    </div>
    <!-- ./wrapper -->

    <!-- Logout Modal -->
    <x-member.modals.logout-modal />

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/myscript.js') }}"></script>

    @yield('scripts')

    @push('js')

    </body>

    </html>
