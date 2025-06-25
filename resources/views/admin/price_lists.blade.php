@extends('admin.template.main')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('admin') }}">
    <link href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection

@section('main-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Daftar Harga</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
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
                    <div class="card">
                        <div class="card-body">
                            <h4>Tambah Data Harga Satuan dan Kiloan</h4>
                            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="satuan-tab" data-toggle="tab" href="#satuan"
                                        role="tab" aria-controls="satuan" aria-selected="true">Satuan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="kiloan-tab" data-toggle="tab" href="#kiloan" role="tab"
                                        aria-controls="kiloan" aria-selected="false">Kiloan</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="satuan" role="tabpanel"
                                    aria-labelledby="satuan-tab">
                                    <form action="{{ route('admin.price-lists.store') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="barang">Barang</label>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <select class="form-control" id="barang" name="item">
                                                                @foreach ($items as $item)
                                                                    <option value="{{ $item->id }}">{{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                            <a id="tambah-barang" class="btn text-white bg-blue-900 hover:bg-blue-950"
                                                                data-toggle="modal" data-target="#addItemModal"><i
                                                                    class="fas fa-plus"></i>
                                                                Tambah Barang</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="servis">Servis</label>
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <select class="form-control" id="servis" name="service">
                                                                @foreach ($services as $service)
                                                                    <option value="{{ $service->id }}">
                                                                        {{ $service->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                            <a id="tambah-servis" class="btn text-white bg-blue-900 hover:bg-blue-950"
                                                                data-toggle="modal" data-target="#addServiceModal"><i
                                                                    class="fas fa-plus"></i>
                                                                Tambah Servis</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="kategori">Kategori</label>
                                                    <select class="form-control" id="kategori" name="category_display"
                                                        disabled>
                                                        @foreach ($categories as $category)
                                                            @if ($category->id == 1)
                                                                <option value="{{ $category->id }}" selected>
                                                                    {{ $category->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <input type="hidden" name="category" value="1">
                                                </div>
                                                <div class="form-group">
                                                    <label for="harga-modal">Harga</label>
                                                    <input type="number" class="form-control" id="harga"
                                                        name="price" requiorange>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn text-white bg-blue-900 hover:bg-blue-950">Tambah Harga</button>
                                    </form>
                                    <br>
                                    <hr>
                                    <br>
                                    <table id="tbl-satuan" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Barang</th>
                                                <th>Servis</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($satuan as $item)
                                                <tr x-data="{ openModal: false }">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->item->name }}</td>
                                                    <td>{{ $item->service->name }}</td>
                                                    <td>{{ $item->getFormattedPrice() }} /PCS</td>
                                                    <td class="whitespace-no-wrap">
                                                        <!-- Tombol Ubah Harga -->
                                                        <a href="#"
                                                            class="btn bg-amber-600 hover:bg-amber-800 duration-200 text-white rounded btn-ubah-harga"
                                                            data-id="{{ $item->id }}" data-toggle="modal"
                                                            data-target="#changePriceModal"><i
                                                                class="fa-solid fa-pen-to-square"></i></a>

                                                        <!-- Tombol Hapus (Trigger Modal) -->
                                                        <button type="button" @click="openModal = true"
                                                            class="btn bg-red-600 hover:bg-red-900 duration-200 text-white rounded text-base ml-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>

                                                        <!-- Modal Konfirmasi -->
                                                        <div x-show="openModal" x-cloak
                                                            class="fixed inset-0 z-50 flex items-center justify-center">
                                                            <!-- Overlay -->
                                                            <div class="absolute inset-0 bg-black/50"
                                                                @click="openModal = false"></div>

                                                            <!-- Konten Modal -->
                                                            <div
                                                                class="relative bg-white rounded-lg shadow-lg w-full max-w-md p-6 z-50">
                                                                <h2 class="text-lg font-semibold mb-4">Konfirmasi Hapus
                                                                </h2>
                                                                <p class="text-sm text-gray-700">
                                                                    Anda yakin ingin menghapus harga
                                                                    <strong>{{ $item->item->name }}</strong> dengan servis
                                                                    <strong>{{ $item->service->name }}</strong>?
                                                                </p>

                                                                <div class="mt-6 flex justify-end gap-2">
                                                                    <button @click="openModal = false"
                                                                        class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100">
                                                                        Batal
                                                                    </button>

                                                                    <form
                                                                        action="{{ route('admin.price-lists.destroy', $item->id) }}"
                                                                        method="POST" @submit="openModal = false">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                                                                            Ya, Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="kiloan" role="tabpanel" aria-labelledby="kiloan-tab">
                                    <form action="{{ route('admin.price-lists.kiloan.store') }}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-6">
                                                {{-- Berat --}}
                                                <div class="form-group">
                                                    <label for="berat">Berat (KG)</label>
                                                    <input type="number" class="form-control" id="heavy"
                                                        name="heavy" step="0.1" required>
                                                </div>

                                                {{-- Kategori --}}
                                                <div class="form-group">
                                                    <label for="kategori-kiloan">Kategori</label>
                                                    <select class="form-control" id="kategori-kiloan"
                                                        name="category_display" disabled>
                                                        <option value="{{ $category->id }}"
                                                            {{ $category->id == 2 ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                    </select>
                                                    <input type="hidden" name="category" value="2">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                {{-- Harga --}}
                                                <div class="form-group">
                                                    <label for="harga-kiloan">Harga</label>
                                                    <input type="number" class="form-control" id="harga-kiloan"
                                                        name="price" required>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn text-white bg-blue-900 hover:bg-blue-950">Tambah Harga</button>
                                    </form>
                                    <br>
                                    <hr>
                                    <br>
                                    <table id="tbl-kiloan" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Berat</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kiloan as $item)
                                                {{-- Tiap baris punya modal-nya sendiri --}}
                                                <tr x-data="{ openKD: false }">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->heavy }} KG</td>
                                                    <td>{{ $item->getFormattedPrice() }} /KG</td>

                                                    <td class="whitespace-no-wrap">
                                                        <!-- Tombol Edit (tetap) -->
                                                        <a href="#"
                                                            class="btn bg-amber-600 hover:bg-amber-800 duration-200 text-white btn-ubah-harga-kiloan"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.price-lists.kiloan.show', $item->id) }}"
                                                            data-toggle="modal" data-target="#changePriceModal">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>

                                                        <!-- Tombol Hapus -->
                                                        <button type="button" @click="openKD = true"
                                                            class="btn bg-red-600 hover:bg-red-900 duration-200 text-white rounded text-base ml-1">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>

                                                        <!-- Modal Konfirmasi -->
                                                        <div x-show="openKD" x-cloak
                                                            class="fixed inset-0 z-50 flex items-center justify-center">
                                                            <!-- Overlay -->
                                                            <div class="absolute inset-0 bg-black/50"
                                                                @click="openKD = false"></div>

                                                            <!-- Kotak Modal -->
                                                            <div class="relative bg-white rounded-lg shadow-lg w-full max-w-md p-6 z-50"
                                                                @keydown.escape.window="openKD=false">
                                                                <h2 class="text-lg font-semibold mb-4">Konfirmasi Hapus
                                                                </h2>
                                                                <p class="text-sm text-gray-700">
                                                                    Yakin hapus harga <strong>{{ $item->heavy }}
                                                                        KG</strong>?
                                                                </p>

                                                                <div class="mt-6 flex justify-end gap-2">
                                                                    <button type="button"
                                                                        class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100"
                                                                        @click="openKD = false">
                                                                        Batal
                                                                    </button>

                                                                    <form
                                                                        action="{{ route('admin.price-lists.kiloan.destroy', $item->id) }}"
                                                                        method="POST" @submit="openKD = false">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="px-4 py-2 rounded bg-red-600 hover:bg-red-700 text-white">
                                                                            Ya, Hapus
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <h5 class="mt-3">Daftar Tipe Service</h5>
                            <div class="tab-content mt-3" id="myTabContent">
                                <table id="#" class="table dataTable dt-responsive nowrap" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Tipe Service</th>
                                            <th>Biaya</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($serviceTypes as $serviceType)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $serviceType->name }}</td>
                                                <td>{{ $serviceType->getFormattedCost() }}</td>
                                                <td>
                                                    <a href="#"
                                                        class="btn bg-amber-600 hover:bg-amber-800 duration-200 text-white rounded text-base btn-update-cost"
                                                        data-id="{{ $serviceType->id }}" data-toggle="modal"
                                                        data-target="#updateCostModal"><i
                                                            class="fa-solid fa-pen-to-square"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('modals')
    <x-admin.modals.change-price-modal />

    <x-admin.modals.update-cost-modal />

    <x-admin.modals.add-item-modal />

    <x-admin.modals.add-service-modal />
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/ajax-harga.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-satuan').DataTable();
            $('#tbl-kiloan').DataTable();
        });
    </script>

    <script>
        $('.btn-ubah-harga-kiloan').on('click', function() {
            const url = $(this).data('url');

            $.get(url, function(data) {
                $('#harga-modal').val(data.price);
                $('#id-harga-modal').val(data.id);
                $('#updatePriceForm').attr('action', `/admin/price-lists/kiloan/${data.id}`);
            });
        });
    </script>
@endsection
