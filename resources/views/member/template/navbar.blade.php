<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('member.points.index') }}">
                <i class="mr-2 fas fa-ticket" style="color: rgb(255, 149, 0)"></i>Tukar Poin
            </a>
        </li>
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
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
