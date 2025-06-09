<div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('member.index') }}"
                    class="nav-link text-white {{ request()->routeIs('member.index') ? 'active bg-white text-cyan-700' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('member.price_lists.index') }}"
                    class="nav-link text-white {{ request()->routeIs('member.price_lists.index') ? 'active bg-white text-cyan-700' : '' }}">
                    <i class="nav-icon fas fa-list"></i>
                    <p>Daftar Harga</p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-file-invoice"></i>
                    <p>Pesanan</p>
                </a>
            </li> --}}
            <li class="nav-item">
                <a href="{{ route('member.transactions.index') }}"
                    class="nav-link text-white {{ request()->routeIs('member.transactions*') ? 'active bg-white text-cyan-700' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Riwayat Transaksi</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('member.points.index') }}"
                    class="nav-link text-white {{ request()->routeIs('member.points.index') ? 'active bg-white text-cyan-700' : '' }}">
                    <i class="nav-icon fas fa-star"></i>
                    <p>Tukar Poin</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('member.complaints.index') }}"
                    class="nav-link text-white {{ request()->routeIs('member.complaints.index') ? 'active bg-white text-cyan-700' : '' }}">
                    <i class="nav-icon fas fa-sticky-note"></i>
                    <p>Feedback</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('profile.index') }}"
                    class="nav-link text-white {{ request()->routeIs('profile.index') ? 'active bg-white text-cyan-700' : '' }}">
                    <i class="nav-icon fas fa-user-edit"></i>
                    <p>Edit Profil</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
