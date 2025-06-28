@extends('admin.template.main')

@section('css')
    <link href="{{ asset('vendor/datatables-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables-responsive/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('main-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Kelola Voucher</h1>
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
                            <button class="btn text-white bg-blue-900 hover:bg-blue-950 mb-3" data-toggle="modal"
                                data-target="#addVoucherModal">Tambah
                                Voucher</button>
                            <h3>Daftar Voucher</h3>
                            <table id="tbl-members" class="table dt-responsive nowrap" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Voucher</th>
                                        <th>Poin Diperlukan</th>
                                        {{-- <th>Keterangan</th> --}}
                                        <th>Detail</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vouchers as $voucher)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $voucher->name }}</td>
                                            <td>{{ $voucher->point_need }}</td>
                                            {{-- <td>{{ $voucher->description }}</td> --}}
                                            <td>{{ $voucher->details }}</td>
                                            <td>
                                                @if ($voucher->active_status != 0)
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input aktif-check" checked
                                                            value="{{ $voucher->id }}">
                                                        <label class="form-check-label">Aktif</label>
                                                    </div>
                                                @else
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input aktif-check"
                                                            value="{{ $voucher->id }}">
                                                        <label class="form-check-label">Aktif</label>
                                                    </div>
                                                @endif |
                                                {{-- <a href="#" class="text-danger"
                                                    onclick="event.preventDefault();
                                                    if (confirm('Yakin ingin menghapus voucher ini?')) {
                                                        document.getElementById('delete-form-{{ $voucher->id }}').submit();
                                                    }">
                                                    Hapus
                                                </a>
                                                <form id="delete-form-{{ $voucher->id }}"
                                                    action="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form> --}}
                                                {{-- TOMBOL UPDATE POIN --}}
                                                <button class="btn btn-sm btn-outline-primary btn-edit"
                                                    data-id="{{ $voucher->id }}" data-point="{{ $voucher->point_need }}"
                                                    data-discount="{{ $voucher->discount_value }}"
                                                    data-details="{{ $voucher->details }}">
                                                    Update Voucher
                                                </button>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </div>
@endsection

@section('modals')
    <x-admin.modals.add-voucher-modal />

    {{-- Modal Edit Voucher --}}
    <div class="modal fade" id="editVoucherModal" tabindex="-1" role="dialog" aria-labelledby="editVoucherLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="edit-voucher-form" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editVoucherLabel">Update Voucher</h5>
                        <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-voucher-id">

                        <div class="form-group">
                            <label for="edit-discount-value">Potongan</label>
                            <input type="number" min="0" class="form-control" name="discount_value"
                                id="edit-discount-value" placeholder="Besar potongan harga" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-point-need">Poin Diperlukan</label>
                            <input type="number" min="0" class="form-control" name="point_need" id="edit-point-need"
                                placeholder="Poin yang dibutuhkan" required>
                        </div>

                        <div class="form-group">
                            <label for="edit-details">Detail Promo Voucher</label>
                            <textarea rows="3" class="form-control" name="details" id="edit-details" placeholder="Detail Voucher" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gray-600 text-white" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    <script src="{{ asset('js/voucher-ajax.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-members').DataTable();
        });
    </script>

    <script>
        $(document).on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            const point = $(this).data('point');
            const discount = $(this).data('discount');
            const details = $(this).data('details');

            $('#edit-voucher-id').val(id);
            $('#edit-point-need').val(point);
            $('#edit-discount-value').val(discount);
            $('#edit-details').val(details);

            // Atur action URL secara dinamis
            const url = "{{ route('admin.vouchers.update', ':id') }}".replace(':id', id);
            $('#edit-voucher-form').attr('action', url);

            $('#editVoucherModal').modal('show');
        });
    </script>
@endsection
