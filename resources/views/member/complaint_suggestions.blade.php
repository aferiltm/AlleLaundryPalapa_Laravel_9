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
                            <h4>Ulasan, Riwayat Saran, dan Komplain</h4>
                            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600 active" id="semuaUlasan-tab" data-toggle="tab"
                                        href="#semuaUlasan" role="tab" aria-controls="semuaUlasan"
                                        aria-selected="true">Semua Ulasan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="ulasanAnda-tab" data-toggle="tab"
                                        href="#ulasanAnda" role="tab" aria-controls="ulasanAnda"
                                        aria-selected="false">Ulasan Anda</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="semuaUlasan" role="tabpanel"
                                    aria-labelledby="semuaUlasan-tab">
                                    <!-- Untuk Semua Ulasan -->
                                    <div class="mb-2">
                                        <label for="filter-rating-semua">Filter Rating:</label>
                                        <select id="filter-rating-semua" class="form-control form-control-sm"
                                            style="width: 150px; display: inline-block;">
                                            <option value="">Semua</option>
                                            <option value="1">1 Bintang</option>
                                            <option value="2">2 Bintang</option>
                                            <option value="3">3 Bintang</option>
                                            <option value="4">4 Bintang</option>
                                            <option value="5">5 Bintang</option>
                                        </select>
                                    </div>
                                    <table id="tbl-semua-ulasan" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                {{-- <th>Tipe</th>
                                                <th>Isi</th>
                                                <th>Balasan</th> --}}
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($allComplaintSuggestions as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                                    <td data-search="{{ $item->rating }}" data-order="{{ $item->rating }}">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $item->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                            @else
                                                                <i class="far fa-star text-muted"></i>
                                                            @endif
                                                        @endfor
                                                    </td>
                                                    <td>{{ $item->review }}</td>
                                                    {{-- <td>{{ $item->type == 1 ? 'Saran' : 'Komplain' }}</td>
                                                    <td>{{ $item->body }}</td>
                                                    <td>
                                                        @if ($item->reply == null)
                                                            <span class="text-danger">Belum ada balasan</span>
                                                        @else
                                                            {{ $item->reply }}
                                                        @endif
                                                    </td> --}}
                                                    <td><a href="#"
                                                            class="btn-detail bg-teal-600 hover:bg-teal-900 duration-200 text-white rounded text-base px-2 py-2"
                                                            data-toggle="modal" data-target="#detailUlasanModal"
                                                            data-nama="{{ $item->user->name ?? '-' }}"
                                                            data-tanggal="{{ date('d F Y', strtotime($item->created_at)) }}"
                                                            data-rating="{{ $item->rating }}"
                                                            data-review="{{ $item->review }}"
                                                            data-tipe="{{ $item->type == 1 ? 'Saran' : 'Komplain' }}"
                                                            data-isi="{{ $item->body }}"
                                                            data-balasan="{{ $item->reply ?? 'Belum ada balasan' }}">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="ulasanAnda" role="tabpanel" aria-labelledby="ulasanAnda-tab">
                                    <!-- Untuk Ulasan Anda -->
                                    <div class="mb-2">
                                        <label for="filter-rating-anda">Filter Rating:</label>
                                        <select id="filter-rating-anda" class="form-control form-control-sm"
                                            style="width: 150px; display: inline-block;">
                                            <option value="">Semua</option>
                                            <option value="1">1 Bintang</option>
                                            <option value="2">2 Bintang</option>
                                            <option value="3">3 Bintang</option>
                                            <option value="4">4 Bintang</option>
                                            <option value="5">5 Bintang</option>
                                        </select>
                                    </div>
                                    <table id="tbl-ulasan-anda" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Rating</th>
                                                <th>Review</th>
                                                {{-- <th>Tipe</th>
                                                <th>Isi</th>
                                                <th>Balasan</th> --}}
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($complaintSuggestions as $complaintSuggestion)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ date('d F Y', strtotime($complaintSuggestion->created_at)) }}
                                                    </td>
                                                    <td data-search="{{ $complaintSuggestion->rating }}"
                                                        data-order="{{ $complaintSuggestion->rating }}">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $complaintSuggestion->rating)
                                                                <i class="fas fa-star text-warning"></i>
                                                                {{-- Bintang penuh --}}
                                                            @else
                                                                <i class="far fa-star text-muted"></i> {{-- Bintang kosong --}}
                                                            @endif
                                                        @endfor
                                                    </td>
                                                    <td>{{ $complaintSuggestion->review }}</td>
                                                    {{-- <td>
                                                        @if ($complaintSuggestion->type == 1)
                                                            Saran
                                                        @else
                                                            Komplain
                                                        @endif
                                                    </td>
                                                    <td>{{ $complaintSuggestion->body }}</td>
                                                    @if ($complaintSuggestion->reply == null)
                                                        <td class="text-danger">
                                                            Belum ada balasan
                                                        </td>
                                                    @else
                                                        <td>
                                                            {{ $complaintSuggestion->reply }}
                                                        </td>
                                                    @endif --}}
                                                    <td><a href="#"
                                                            class="btn-detail bg-teal-600 hover:bg-teal-900 duration-200 text-white rounded text-base px-2 py-2"
                                                            data-toggle="modal" data-target="#detailUlasanModal"
                                                            data-nama="{{ $complaintSuggestion->user->name ?? '-' }}"
                                                            data-tanggal="{{ date('d F Y', strtotime($complaintSuggestion->created_at)) }}"
                                                            data-rating="{{ $complaintSuggestion->rating }}"
                                                            data-review="{{ $complaintSuggestion->review }}"
                                                            data-tipe="{{ $complaintSuggestion->type == 1 ? 'Saran' : 'Komplain' }}"
                                                            data-isi="{{ $complaintSuggestion->body }}"
                                                            data-balasan="{{ $complaintSuggestion->reply ?? 'Belum ada balasan' }}">
                                                            <i class="fa-solid fa-circle-info"></i>
                                                        </a>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Modal Detail Ulasan -->
    <div class="modal fade" id="detailUlasanModal" tabindex="-1" role="dialog"
        aria-labelledby="detailUlasanModalLabel" aria-hidden="true">
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
                    <div class="mb-2"><strong>Tanggal:</strong> <span id="detail-tanggal"></span></div>
                    <div class="mb-2"><strong>Rating:</strong> <span id="detail-rating"></span></div>
                    <div class="mb-2"><strong>Review:</strong> <span id="detail-review"></span></div>
                    <div class="mb-2"><strong>Tipe:</strong> <span id="detail-tipe"></span></div>
                    <div class="mb-2"><strong>Isi:</strong> <span id="detail-isi"></span></div>
                    <div class="mb-2"><strong>Balasan:</strong> <span id="detail-balasan"></span></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Tutup</button>
                </div>
            </div>
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
        $('.btn-detail').on('click', function() {
            $('#detail-nama').text($(this).data('nama'));
            $('#detail-tanggal').text($(this).data('tanggal'));
            $('#detail-rating').html(renderStars($(this).data('rating')));
            $('#detail-review').text($(this).data('review'));
            $('#detail-tipe').text($(this).data('tipe'));
            $('#detail-isi').text($(this).data('isi'));
            $('#detail-balasan').text($(this).data('balasan'));
        });

        // Fungsi render bintang dari rating
        function renderStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += i <= rating ?
                    '<i class="fas fa-star text-warning"></i>' :
                    '<i class="far fa-star text-muted"></i>';
            }
            return stars;
        }
    </script>
    <script>
        $(document).ready(function() {
            const tableSemua = $('#tbl-semua-ulasan').DataTable();
            const tableAnda = $('#tbl-ulasan-anda').DataTable();

            // Custom filter untuk rating di Semua Ulasan
            $('#filter-rating-semua').on('change', function() {
                const selected = $(this).val();
                if (selected) {
                    tableSemua.column(2).search('^' + selected + '$', true, false).draw();
                } else {
                    tableSemua.column(2).search('').draw();
                }
            });

            // Custom filter untuk rating di Ulasan Anda
            $('#filter-rating-anda').on('change', function() {
                const selected = $(this).val();
                if (selected) {
                    tableAnda.column(2).search('^' + selected + '$', true, false).draw();
                } else {
                    tableAnda.column(2).search('').draw();
                }
            });
        });
    </script>
@endsection
