@extends('admin.template.main')

@section('css')
    <link href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Tambah Pesanan</h1>
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
                                    <form action="{{ route('admin.transactions.session.store.satuan') }}" method="post"
                                        onsubmit="return showAddOrderAlert('kiloan')">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="phone_number" class="col-sm-2 col-form-label">Data Member</label>
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control"
                                                    id="member_name"name="member_name"
                                                    value="{{ session('member_name', '') }}" placeholder="Nama Member"
                                                    readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control"
                                                    id="phone_number"name="phone_number"
                                                    value="{{ session('phone_number', '') }}"
                                                    placeholder="Masukkan Nomor Telpon/HP">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="number" min="1" class="form-control" id="id-member"
                                                    name="member-id" placeholder="Id Member" readonly
                                                    @if (isset($memberIdSessionTransaction)) value="{{ $memberIdSessionTransaction }}"
                                                    disabled title="Harap selesaikan transaksi yang ada untuk mengganti id member" @endif
                                                    required hidden>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="barang" class="col-sm-2 col-form-label">Barang</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="barang" name="item">
                                                    @foreach ($items as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="servis" class="col-sm-2 col-form-label">Servis</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="servis" name="service">
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="kategori" name="category">
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="banyak" class="col-sm-2 col-form-label">Banyak</label>
                                            <div class="col-sm-1">
                                                <div class="input-group">
                                                    <input type="text" id="quantity" name="quantity"
                                                        class="form-control input-number" value="" min="1"
                                                        max="10" oninput="checkQuantity()" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="submit" id="tambah-transaksi"
                                                    class="btn btn-success">Tambah
                                                    Pesanan Satuan</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="tbl-input-transaksi" class="table mt-2 dt-responsive nowrap"
                                        style="width: 100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Barang</th>
                                                <th>Servis</th>
                                                <th>Kategori</th>
                                                <th>Banyak</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($sessionTransaction))
                                                @foreach ($sessionTransaction as $transaction)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $transaction['itemName'] ?? 'N/A' }}</td>
                                                        <td>{{ $transaction['serviceName'] ?? 'N/A' }}</td>
                                                        <td>{{ $transaction['categoryName'] ?? 'N/A' }}</td>
                                                        <td>{{ $transaction['quantity'] ?? 0 }}</td>
                                                        <td>{{ $transaction['subTotal'] ?? 0 }}</td>
                                                        <td>
                                                            <a href="#"
                                                                onclick="confirmAndDelete('{{ route('admin.transactions.session.destroy', ['rowId' => $transaction['rowId']]) }}');"
                                                                class="bg-red-600 hover:bg-red-900 duration-200 text-white rounded text-base px-2 py-2"><i
                                                                    class="fa-solid fa-trash-can"></i></a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="kiloan" role="tabpanel" aria-labelledby="kiloan-tab">
                                    <form action="{{ route('admin.transactions.session.store.kiloan') }}" method="post"
                                        onsubmit="return showAddOrderAlert('kiloan')">
                                        @csrf
                                        <div class="form-group row">
                                            <label for="phone_number" class="col-sm-2 col-form-label">Data Member</label>
                                            {{-- <label for="id-member" class="col-sm-2 col-form-label">Kode Member</label> --}}
                                            <div class="col-sm-4">
                                                <input type="text" class="form-control"
                                                    id="member_name_kiloan"name="member_name"
                                                    value="{{ session('member_name', '') }}" placeholder="Nama Member"
                                                    readonly>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" id="phone_number_kiloan"
                                                    name="phone_number" value="{{ session('phone_number', '') }}"
                                                    placeholder="Masukkan Nomor Telpon/HP">
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="number" min="1" class="form-control"
                                                    id="id-member-kiloan" name="member-id" placeholder="Id Member"
                                                    readonly
                                                    @if (isset($memberIdSessionTransaction)) value="{{ $memberIdSessionTransaction }}"
                                                    disabled title="Harap selesaikan transaksi yang ada untuk mengganti id member" @endif
                                                    required hidden>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                                            <div class="col-sm-4">
                                                <select class="form-control" id="kategori" name="categoryKiloan"
                                                    disabled>
                                                    @foreach ($categories_kiloan as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input type="hidden" name="categoryKiloan" value="2">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="banyak" class="col-sm-2 col-form-label">Banyak</label>
                                            <div class="col-sm-1">
                                                <div class="input-group">
                                                    <input type="text" id="heavy" name="heavy"
                                                        class="form-control input-number" value="" min="1"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="submit" id="tambah-transaksi-kiloan"
                                                    class="btn btn-success">Tambah
                                                    Pesanan Kiloan</button>
                                            </div>
                                        </div>
                                    </form>
                                    <table id="tbl-input-transaksi" class="table mt-2 dt-responsive nowrap"
                                        style="width: 100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kategori</th>
                                                <th>Berat</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($sessionTransaction))
                                                @foreach ($sessionTransaction as $transaction)
                                                    @if (isset($transaction['categoryKiloanId']))
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $transaction['categoryNameKiloan'] }}</td>
                                                            <td>{{ $transaction['heavy'] }}</td>
                                                            <td>{{ $transaction['subTotalKiloan'] }}</td>
                                                            <td>
                                                                <a href="#"
                                                                    onclick="confirmAndDelete('{{ route('admin.transactions.session.destroy', ['rowId' => $transaction['rowId']]) }}');"
                                                                    class="bg-red-600 hover:bg-red-900 duration-200 text-white rounded text-base px-2 py-2"><i
                                                                        class="fa-solid fa-trash-can"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (isset($sessionTransaction))
                                <button id="btn-bayar" class="btn btn-success" data-toggle="modal"
                                    data-target="#paymentModal">Bayar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('modals')
    <x-admin.modals.payment-modal :$serviceTypes :vouchers="$vouchers ?? []" :totalPrice="$totalPrice ?? '0'" :show="isset($sessionTransaction)" />
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-input-transaksi').DataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false
            });
            $('#tbl-input-transaksi-kiloan').DataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false
            });
        });
    </script>
    <script>
        function checkQuantity() {
            var input = document.getElementById('quantity');
            var max = 10;

            if (input.value > max) {
                input.value = max;
            }
        }

        function confirmAndDelete(deleteUrl) {
            // Menampilkan dialog konfirmasi kepada admin
            if (confirm('Apakah Anda yakin ingin menghapus Data Pesanan?')) {
                // Jika admin menekan OK, tampilkan alert bahwa data pesanan berhasil dihapus
                alert('Data pesanan berhasil dihapus!');
                // Redirect ke URL penghapusan
                window.location.href = deleteUrl;
            } else {
                // Jika admin memilih Cancel, tidak melakukan apa-apa
                // Admin memilih untuk tidak menghapus data pesanan
            }
        }

        function validateOrderType(orderType) {
            // Cek apakah ada transaksi yang sudah ada di sesi
            let hasSatuan = @json(isset($sessionTransaction) &&
                    count(array_filter($sessionTransaction, function ($transaction) {
                            return isset($transaction['itemId']);
                        })) > 0);
            let hasKiloan = @json(isset($sessionTransaction) &&
                    count(array_filter($sessionTransaction, function ($transaction) {
                            return isset($transaction['categoryKiloanId']);
                        })) > 0);
            if (orderType === 'satuan' && hasKiloan) {
                alert("Sedang dalam pesanan kiloan");
                return false;
            }

            if (orderType === 'kiloan' && hasSatuan) {
                alert("Sedang dalam pesanan satuan");
                return false;
            }
            return true;
        }

        // function showAddOrderAlert() {
        //     alert('Pesanan berhasil ditambahkan!');
        // }
        // Modifikasi fungsi showAddOrderAlert untuk memanggil validateOrderType

        function showAddOrderAlert(orderType) {
            if (validateOrderType(orderType)) {
                alert('Pesanan berhasil ditambahkan!');
            } else {
                return false; // Mencegah form submit jika validasi gagal
            }
        }
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#phone_number').on('input', function() {
                let userCode = $(this).val();
                if (userCode.length >= 3) { // Mulai pencarian setelah 3 karakter
                    $.ajax({
                        url: "{{ route('admin.members.search') }}",
                        method: "GET",
                        data: {
                            phone_number: userCode
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#member_name').val(response.name);
                                $('#id-member').val(response.id);
                            } else {
                                $('#member_name').val('');
                                $('#id-member').val('');
                            }
                        }
                    });
                } else {
                    $('#member_name').val('');
                    $('#id-member').val('');
                }
            });
            $('#phone_number_kiloan').on('input', function() {
                let userCode = $(this).val();
                if (userCode.length >= 3) { // Mulai pencarian setelah 3 karakter
                    $.ajax({
                        url: "{{ route('admin.members.search') }}",
                        method: "GET",
                        data: {
                            phone_number: userCode
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#member_name_kiloan').val(response.name);
                                $('#id-member-kiloan').val(response.id);
                            } else {
                                $('#member_name_kiloan').val('');
                                $('#id-member-kiloan').val('');
                            }
                        }
                    });
                } else {
                    $('#member_name_kiloan').val('');
                    $('#id-member-kiloan').val('');
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let successMessage = "{{ session('success') }}";
            if (successMessage) {
                document.getElementById('phone_number').value = '';
                document.getElementById('member_name').value = '';
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek apakah sudah ada transaksi yang tersimpan di sesi
            let hasTransaction = @json(isset($sessionTransaction) && count($sessionTransaction) > 0);

            if (hasTransaction) {
                document.getElementById("phone_number").readOnly = true;
            }
            if (hasTransaction) {
                document.getElementById("phone_number_kiloan").readOnly = true;
            }

            document.getElementById("tambah-transaksi").addEventListener("click", function() {
                document.getElementById("phone_number").readOnly = true;
            });
            document.getElementById("tambah-transaksi-kiloan").addEventListener("click", function() {
                document.getElementById("phone_number_Kiloan").readOnly = true;
            });
        });
    </script>


    @if (session('id_trs'))
        <script type="text/javascript">
            window.open('{{ route('admin.transactions.print.index', ['transaction' => session('id_trs')]) }}', '_blank');
        </script>
    @endif
@endsection
