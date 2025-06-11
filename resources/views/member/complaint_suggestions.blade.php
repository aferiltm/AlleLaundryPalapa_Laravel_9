@extends('member.template.main')

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
                    <h1 class="m-0 text-dark">Saran atau Komplain</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">

            <div class=row>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Saran dan Komplain</h4>
                            <table class="table dataTable dt-responsive nowrap" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tipe Service</th>
                                        <th>Tanggal Selesai</th>
                                        <th>Tipe</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->transaction_code }}</td>
                                            <td>{{ $item->service_type->name }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->finish_date)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}
                                            </td>
                                            <td>{{ $item->complaint_suggestion->type ?? '-' }}</td>
                                            <td>
                                                <button class="btn btn-info btn-detail" data-toggle="modal"
                                                    data-target="#detailUlasanModal"
                                                    data-kode-transaksi="{{ $item->transaction_code }}"
                                                    data-nama="{{ $item->member->name ?? '-' }}"
                                                    data-tanggal-dibuat="{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}"
                                                    data-tanggal-selesai="{{ \Carbon\Carbon::parse($item->finish_date)->locale('id')->timezone('Asia/Jakarta')->translatedFormat('l, d F Y H:i') }}"
                                                    data-tipe="{{ $item->complaint_suggestion->type ?? '-' }}"
                                                    data-isi="{{ $item->complaint_suggestion->feedback ?? '-' }}"
                                                    data-balasan="{{ $item->complaint_suggestion->reply ?? '-' }}">
                                                    Detail
                                                </button> | @if ($item->complaint_suggestion)
                                                    <button class="btn btn-secondary" disabled>Sudah Dikirim</button>
                                                @else
                                                    <button class="btn btn-warning btn-open-form"
                                                        data-id="{{ $item->id }}">Beri Saran/Komplain</button>
                                                @endif


                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Modal Detail Ulasan -->
    <div class="modal fade" id="detailUlasanModal" tabindex="-1" role="dialog" aria-labelledby="detailUlasanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-teal-600 text-white">
                    <h5 class="modal-title" id="detailUlasanModalLabel">Detail Ulasan</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body text-sm">
                    <div class="mb-2"><strong>Nama:</strong> <span id="detail-nama"></span></div>
                    <div class="mb-2"><strong>Kode Transaksi:</strong> <span id="detail-kode-transaksi"></span></div>
                    <div class="mb-2"><strong>Tanggal Dibuat:</strong> <span id="detail-tanggal-dibuat"></span></div>
                    <div class="mb-2"><strong>Tanggal Selesai:</strong> <span id="detail-tanggal-selesai"></span></div>
                    <div class="mb-2"><strong>Tipe:</strong> <span id="detail-tipe"></span></div>
                    <div class="mb-2"><strong>Isi Feedback:</strong> <span id="detail-isi"></span></div>
                    <div class="mb-2"><strong>Balasan:</strong> <span id="detail-balasan"></span></div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form Saran/Komplain -->
    <div class="modal fade" id="formSaranKomplainModal" tabindex="-1" role="dialog"
        aria-labelledby="formSaranKomplainLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="{{ route('member.complaints.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="formSaranKomplainLabel">Beri Saran atau Komplain</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-sm">
                        <input type="hidden" name="transaction_id" id="form-transaction-id">

                        <div class="form-group">
                            <label for="type">Tipe</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">-- Pilih Tipe --</option>
                                <option value="Saran">Saran</option>
                                <option value="Komplain">Komplain</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="feedback">Isi Feedback</label>
                            <textarea name="feedback" id="feedback" class="form-control" rows="4" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-semua-ulasan').DataTable();
            $('#tbl-ulasan-anda').DataTable();
        });
    </script>
    <script>
        $(document).on('click', '.btn-detail', function() {
            $('#detail-nama').text($(this).data('nama'));
            $('#detail-kode-transaksi').text($(this).data('kode-transaksi'));
            $('#detail-tanggal-dibuat').text($(this).data('tanggal-dibuat'));
            $('#detail-tanggal-selesai').text($(this).data('tanggal-selesai'));
            $('#detail-tipe').text($(this).data('tipe'));
            $('#detail-isi').text($(this).data('isi'));
            $('#detail-balasan').text($(this).data('balasan'));
        });
    </script>
    <script>
        $(document).on('click', '.btn-open-form', function() {
            const transactionId = $(this).data('id');
            $('#form-transaction-id').val(transactionId);
            $('#formSaranKomplainModal').modal('show');
        });
    </script>
@endsection
