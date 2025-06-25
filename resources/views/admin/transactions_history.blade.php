@extends('admin.template.main')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('admin') }}">
    <link href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Riwayat Transaksi</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="form-group row">
                                    <label for="tahun" class="col-auto col-form-label">Tahun</label>
                                    <div class="col-auto">
                                        <select class="form-control" id="tahun" name="year">
                                            @foreach ($years as $year)
                                                @if ($year->tahun == $currentYear)
                                                    <option value="{{ $year->Tahun }}" selected>{{ $year->Tahun }}
                                                    </option>
                                                @else
                                                    <option value="{{ $year->Tahun }}">{{ $year->Tahun }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <label for="bulan" class="col-auto col-form-label">Bulan</label>
                                    <div class="col-auto">
                                        <select class="form-control" id="bulan" name="month">
                                            @for ($i = 1; $i <= 12; $i++)
                                                @if ($i == $currentMonth)
                                                    <option value="{{ $i }}" selected>
                                                        {{ $i }}</option>
                                                @else
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" id="btn-filter" class="btn text-white bg-blue-900 hover:bg-blue-950">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class=row>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Data Transaksi Berjalan</h4>
                            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600 active" id="kilatService-tab" data-toggle="tab"
                                        href="#kilatService" role="tab" aria-controls="kilatService"
                                        aria-selected="true">Kilat Service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="expressService-tab" data-toggle="tab"
                                        href="#expressService" role="tab" aria-controls="expressService"
                                        aria-selected="false">Express Service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="regulerService-tab" data-toggle="tab"
                                        href="#regulerService" role="tab" aria-controls="regulerService"
                                        aria-selected="false">Reguler
                                        Service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="selesai-tab" data-toggle="tab" href="#selesai"
                                        role="tab" aria-controls="selesai" aria-selected="false">Selesai</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="kilatService" role="tabpanel"
                                    aria-labelledby="kilatService-tab">
                                    <table id="tbl-transaksi-kilat" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Nama Member</th>
                                                <th>Status</th>
                                                <th>Biaya Service</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ongoingKilatTransactions as $item)
                                                <tr>
                                                    <td>{{ $item->transaction_code }}</td>
                                                    <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                    <td>{{ $item->member->name }}</td>
                                                    <td>
                                                        @if ($item->status_id == 3)
                                                            <span class="text-success">Selesai</span>
                                                        @else
                                                            <select name="" id="status"
                                                                data-id="{{ $item->id }}"
                                                                data-val="{{ $item->status_id }}"
                                                                class="select-status px-2 rounded">
                                                                @foreach ($status as $s)
                                                                    @if ($item->status_id == $s->id)
                                                                        <option selected value="{{ $s->id }}">
                                                                            {{ $s->name }}</option>
                                                                    @else
                                                                        <option value="{{ $s->id }}">
                                                                            {{ $s->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->getFormattedServiceCost() }}</td>
                                                    <td>{{ $item->getFormattedTotal() }}</td>
                                                    <td>
                                                        <a href="#"
                                                            class="bg-teal-600 hover:bg-teal-900 duration-200 text-white rounded text-base px-2 py-2 btn-detail"
                                                            data-toggle="modal" data-target="#transactionDetailModal"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.transactions.show', $item->id) }}"><i
                                                                class="fa-solid fa-circle-info"></i></a>
                                                        <a href="{{ route('admin.transactions.print.index', ['transaction' => $item->id]) }}"
                                                            class="bg-blue-600 hover:bg-blue-900 duration-200 text-white rounded text-base px-2 py-2"
                                                            target="_blank"><i class="fa-solid fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="expressService" role="tabpanel"
                                    aria-labelledby="expressService-tab">
                                    <table id="tbl-transaksi-express" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Nama Member</th>
                                                <th>Status</th>
                                                <th>Biaya Service</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ongoingExpressTransactions as $item)
                                                <tr>
                                                    <td>{{ $item->transaction_code }}</td>
                                                    <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                    <td>{{ $item->member->name }}</td>
                                                    <td>
                                                        @if ($item->status_id == 3)
                                                            <span class="text-success">Selesai</span>
                                                        @else
                                                            <select name="" class="select-status px-2 rounded"
                                                                data-id="{{ $item->id }}"
                                                                data-val="{{ $item->status_id }}">
                                                                @foreach ($status as $s)
                                                                    <option value="{{ $s->id }}"
                                                                        {{ $item->status_id == $s->id ? 'selected' : '' }}>
                                                                        {{ $s->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->getFormattedServiceCost() }}</td>
                                                    <td>{{ $item->getFormattedTotal() }}</td>
                                                    <td>
                                                        <a href="#"
                                                            class="bg-teal-600 hover:bg-teal-900 duration-200 text-white rounded text-base px-2 py-2 btn-detail"
                                                            data-toggle="modal" data-target="#transactionDetailModal"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.transactions.show', $item->id) }}"><i
                                                                class="fa-solid fa-circle-info"></i></a>
                                                        <a href="{{ route('admin.transactions.print.index', ['transaction' => $item->id]) }}"
                                                            class="bg-blue-600 hover:bg-blue-900 duration-200 text-white rounded text-base px-2 py-2"
                                                            target="_blank"><i class="fa-solid fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="regulerService" role="tabpanel"
                                    aria-labelledby="regulerService-tab">
                                    <table id="tbl-transaksi-reguler" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Nama Member</th>
                                                <th>Status</th>
                                                <th>Biaya Service</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($ongoingTransactions as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->transaction_code }}</td>
                                                    <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                    <td>{{ $item->member->name }}</td>
                                                    <td>
                                                        @if ($item->status_id == 3)
                                                            <span class="text-success">Selesai</span>
                                                        @else
                                                            <select name="" id="status"
                                                                data-id="{{ $item->id }}"
                                                                data-val="{{ $item->status_id }}"
                                                                class="select-status px-2 rounded">
                                                                @foreach ($status as $s)
                                                                    @if ($item->status_id == $s->id)
                                                                        <option selected value="{{ $s->id }}">
                                                                            {{ $s->name }}</option>
                                                                    @else
                                                                        <option value="{{ $s->id }}">
                                                                            {{ $s->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->getFormattedServiceCost() }}</td>
                                                    <td>{{ $item->getFormattedTotal() }}</td>
                                                    <td>
                                                        <a href="#"
                                                            class="bg-teal-600 hover:bg-teal-900 duration-200 text-white rounded text-base px-2 py-2 btn-detail"
                                                            data-toggle="modal" data-target="#transactionDetailModal"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.transactions.show', $item->id) }}"><i
                                                                class="fa-solid fa-circle-info"></i></a>
                                                        <a href="{{ route('admin.transactions.print.index', ['transaction' => $item->id]) }}"
                                                            class="bg-blue-600 hover:bg-blue-900 duration-200 text-white rounded text-base px-2 py-2"
                                                            target="_blank"><i class="fa-solid fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="selesai" role="tabpanel" aria-labelledby="selesai-tab">
                                    <table id="tbl-transaksi-selesai" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Nama Member</th>
                                                <th>Status</th>
                                                <th>Biaya Service</th>
                                                <th>Total Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($finishedTransactions as $item)
                                                <tr>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                    <td>{{ $item->member->name }}</td>
                                                    <td>
                                                        @if ($item->status_id == 3)
                                                            <span class="text-success">Selesai</span>
                                                        @else
                                                            <select name="" id="status"
                                                                data-id="{{ $item->id }}"
                                                                data-val="{{ $item->status_id }}"
                                                                class="select-status px-2 rounded">
                                                                @foreach ($status as $s)
                                                                    @if ($item->status_id == $s->id)
                                                                        <option selected value="{{ $s->id }}">
                                                                            {{ $s->name }}</option>
                                                                    @else
                                                                        <option value="{{ $s->id }}">
                                                                            {{ $s->name }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->getFormattedServiceCost() }}</td>
                                                    <td>{{ $item->getFormattedTotal() }}</td>
                                                    <td>
                                                        <a href="#"
                                                            class="bg-teal-600 hover:bg-teal-900 duration-200 text-white rounded text-base px-2 py-2 btn-detail"
                                                            data-toggle="modal" data-target="#transactionDetailModal"
                                                            data-id="{{ $item->id }}"
                                                            data-url="{{ route('admin.transactions.show', $item->id) }}"><i
                                                                class="fa-solid fa-circle-info"></i></a>
                                                        <a href="{{ route('admin.transactions.print.index', ['transaction' => $item->id]) }}"
                                                            class="bg-blue-600 hover:bg-blue-900 duration-200 text-white rounded text-base px-2 py-2"
                                                            target="_blank"><i class="fa-solid fa-print"></i></a>
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
            </div>

        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('modals')
    <x-admin.modals.transaction-detail-modal />
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-transaksi-selesai').DataTable();
            $('#tbl-transaksi-reguler').DataTable();
            $('#tbl-transaksi-express').DataTable();
            $('#tbl-transaksi-kilat').DataTable();
        });
    </script>

    <script>
        $(document).on('change', '.select-status', function() {
            const statusId = $(this).val();
            const transactionId = $(this).data('id');

            $.ajax({
                url: '{{ route('admin.transactions.updateStatus') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: transactionId,
                    status_id: statusId
                },
                success: function(response) {
                    alert('Status berhasil diperbarui!');
                },
                error: function() {
                    alert('Terjadi kesalahan.');
                }
            });
        });
    </script>
@endsection
