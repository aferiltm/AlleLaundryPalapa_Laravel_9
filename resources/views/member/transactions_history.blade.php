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

                            <table id="tbl-riwayat" class="table dataTable dt-responsive nowrap" style="width:100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        <th>Beri Ulasan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $transaction->transaction_code }}</td>
                                            <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                                            <td>
                                                @if ($transaction->status_id == 3)
                                                    <span
                                                        class="p-1 bg-success text-white rounded">{{ $transaction->status->name }}</span>
                                                @elseif ($transaction->status_id == 2)
                                                    <span
                                                        class="p-1 bg-warning text-white rounded">{{ $transaction->status->name }}</span>
                                                @else
                                                    <span
                                                        class="p-1 bg-danger text-white rounded">{{ $transaction->status->name }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('member.transactions.show', ['transaction' => $transaction->id]) }}"
                                                    class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                                            </td>
                                            <td>
                                                @if ($transaction->status_id == 3)
                                                    @if ($transaction->hasReview())
                                                        <button class="btn btn-secondary" disabled>
                                                            Ulasan <i class="fa-solid fa-star"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success" data-toggle="modal"
                                                            data-target="#reviewModal{{ $transaction->id }}">
                                                            Ulasan <i class="fa-solid fa-star"></i>
                                                        </button>
                                                    @endif

                                                    @if ($transaction->hasFeedback())
                                                        <button class="btn bg-gray-500 text-white" disabled>
                                                            Sudah Komplain <i class="fa-solid fa-circle-check"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-warning" data-toggle="modal"
                                                            data-target="#formSaranKomplainModal{{ $transaction->id }}">
                                                            Beri Saran/Komplain <i
                                                                class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>

                                        @if ($transaction->status_id == 3 && !$transaction->hasReview())
                                            <!-- Modal Ulasan -->
                                            <div class="modal fade" id="reviewModal{{ $transaction->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="reviewModalLabel{{ $transaction->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="reviewModalLabel{{ $transaction->id }}">Beri
                                                                Ulasan/Review
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('member.review.store') }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <input type="hidden" name="transaction_id"
                                                                    value="{{ $transaction->id }}">
                                                                <div class="form-group">
                                                                    <label for="rating">Rating</label>
                                                                    <select name="rating" class="form-control" required>
                                                                        <option value="5">⭐⭐⭐⭐⭐ - Sangat Baik</option>
                                                                        <option value="4">⭐⭐⭐⭐ - Baik</option>
                                                                        <option value="3">⭐⭐⭐ - Cukup</option>
                                                                        <option value="2">⭐⭐ - Kurang</option>
                                                                        <option value="1">⭐ - Buruk</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea class="form-control" name="review" rows="4"></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Kirim Ulasan
                                                                    <i class="fa-solid fa-paper-plane"></i></button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if ($transaction->status_id == 3 && !$transaction->hasReview())
                                            <!-- Modal Saran atau Komplain -->
                                            <div class="modal fade" id="formSaranKomplainModal{{ $transaction->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="formSaranKomplainLabel{{ $transaction->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <form method="POST" action="{{ route('member.complaints.store') }}">
                                                        @csrf
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-warning text-white">
                                                                <h5 class="modal-title"
                                                                    id="formSaranKomplainLabel{{ $transaction->id }}">Beri
                                                                    Saran atau
                                                                    Komplain</h5>
                                                                <button type="button" class="close text-white"
                                                                    data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body text-sm">
                                                                <input type="hidden" name="transaction_id"
                                                                    value="{{ $transaction->id }}">

                                                                <div class="form-group">
                                                                    <label for="type">Tipe</label>
                                                                    <select name="type" id="type-{{ $transaction->id }}"
                                                                        class="form-control" required>
                                                                        <option value="">-- Pilih Tipe --</option>
                                                                        <option value="Saran">Saran</option>
                                                                        <option value="Komplain">Komplain</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="feedback">Isi Feedback</label>
                                                                    <textarea name="feedback" id="feedback-{{ $transaction->id }}" class="form-control" rows="4" required></textarea>
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn bg-gray-600 text-white"
                                                                    data-dismiss="modal">Batal</button>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Kirim</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
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
@endsection

@section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-riwayat').DataTable();
        });
    </script>
@endsection
