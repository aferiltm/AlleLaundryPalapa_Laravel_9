@section('css')
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            {{-- <a class="nav-link" data-toggle="dropdown" href="#">
                <img class="img-circle img-fit mr-1" width="25" height="25" src="{{ $user->getFileAsset() }}"
                    alt="Foto Profil">
                {{ $user->name }}
            </a> --}}
            <a class="nav-link" data-toggle="dropdown" href="#">
                <div class="flex flex-row">
                    <img class="img-circle img-fit mr-2" width="25" height="25" src="{{ $user->getFileAsset() }}"
                        alt="Foto Profil">
                    <span>{{ $user->name }}</span>
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <a href="{{ route('profile.index') }}" class="dropdown-item">
                    <i class="fas fa-user-edit mr-2"></i> Edit Profil
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </div>
        </li>
    </ul>

    {{-- <ul class="navbar-nav ml-auto flex items-center space-x-4">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown relative">
            <a class="nav-link flex items-center gap-2" data-toggle="dropdown" href="#">
                <img class="w-6 h-6 rounded-full object-cover" src="{{ $user->getFileAsset() }}" alt="Foto Profil">
                <span class="text-gray-700 font-medium"> {{ $user->name }} </span>
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md">
                <a href="{{ route('profile.index') }}" class="dropdown-item flex items-center px-4 py-2 hover:bg-gray-100">
                    <i class="fas fa-user-edit mr-2"></i> Edit Profil
                </a>
                <div class="border-t"></div>
                <a href="#" class="dropdown-item flex items-center px-4 py-2 hover:bg-gray-100" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </a>
            </div>
        </li>
    </ul> --}}


</nav>
