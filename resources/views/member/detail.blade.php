@extends('member.template.main')

@section('css')
    <link href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('main-content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Detail Transaksi</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>ID Transaksi: {{ $id }}</h3>
                            <hr>

                            {{-- TABEL SATUAN --}}
                            @if (count($transactions) > 0)
                                <table id="tbl-detail" class="table dataTable dt-responsive nowrap" style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Barang</th>
                                            <th>Kategori</th>
                                            <th>Servis</th>
                                            <th>Banyak</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactions as $transaction)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $transaction->price_list->item->name }}</td>
                                                <td>{{ $transaction->price_list->category->name }}</td>
                                                <td>{{ $transaction->price_list->service->name }}</td>
                                                <td>{{ $transaction->quantity }}</td>
                                                <td>{{ $transaction->getFormattedPrice() }}</td>
                                                <td>{{ $transaction->getFormattedSubTotal() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            {{-- TABEL KILOAN --}}
                            @if (count($transactionsKiloan) > 0)
                                <table id="tbl-detail-kiloan" class="table dataTable dt-responsive nowrap"
                                    style="width:100%">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Kategori</th>
                                            <th>Banyak</th>
                                            <th>Harga</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transactionsKiloan as $transaction)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $transaction->price_list_kiloan->category_kiloan->name }}</td>
                                                <td>{{ $transaction->quantity }}</td>
                                                <td>{{ $transaction->getFormattedPrice() }}</td>
                                                <td>{{ $transaction->getFormattedSubTotal() }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <hr>

                            {{-- DETAIL SATUAN --}}
                            @if (count($transactions) > 0)
                                <h5>Tipe Servis: {{ $transactions[0]->transaction->service_type->name }}</h5>
                                <h5>Biaya Servis: {{ $transactions[0]->transaction->getFormattedServiceCost() }}</h5>
                                <h5>Potongan: {{ $transactions[0]->transaction->discount }}</h5>
                                <hr>
                                <h4>Total Biaya: {{ $transactions[0]->transaction->getFormattedTotal() }}</h4>
                                <h4>Dibayar: {{ $transactions[0]->transaction->getFormattedPaymentAmount() }}</h4>
                                <h4>Kembalian: Rp.
                                    {{ number_format($transactions[0]->transaction->payment_amount - $transactions[0]->transaction->total, 0, ',', '.') }}
                                </h4>
                            @endif

                            {{-- DETAIL KILOAN --}}
                            @if (count($transactionsKiloan) > 0)
                                <h5>Tipe Servis: {{ $transactionsKiloan[0]->transaction->service_type->name }}</h5>
                                <h5>Biaya Servis: {{ $transactionsKiloan[0]->transaction->getFormattedServiceCost() }}</h5>
                                <h5>Potongan: {{ $transactionsKiloan[0]->transaction->discount }}</h5>
                                <hr>
                                <h4>Total Biaya: {{ $transactionsKiloan[0]->transaction->getFormattedTotal() }}</h4>
                                <h4>Dibayar: {{ $transactionsKiloan[0]->transaction->getFormattedPaymentAmount() }}</h4>
                                <h4>Kembalian: Rp.
                                    {{ number_format($transactionsKiloan[0]->transaction->payment_amount - $transactionsKiloan[0]->transaction->total, 0, ',', '.') }}
                                </h4>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/quantity-increment.js') }}"></script>
    <script src="{{ asset('js/input-transaksi.js') }}"></script>
@endpush

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-detail').DataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false
            });
            $('#tbl-detail-kiloan').DataTable({
                "searching": false,
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": false,
                "bInfo": false
            });

            // Hide or show table sesuai data
            @if (count($transactions) == 0)
                $('#tbl-detail').parents('table').hide();
            @endif

            @if (count($transactionsKiloan) == 0)
                $('#tbl-detail-kiloan').parents('table').hide();
            @endif
        });
    </script>
@endsection
