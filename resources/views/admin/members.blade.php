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
                    <h1 class="m-0 text-dark">Daftar Member</h1>
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

                            <div class="mb-3">
                                <a href="#" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modalTambahMember">
                                    <i class="fas fa-plus"></i> Tambah Member
                                </a>
                            </div>

                            <table id="tbl-members" class="table dt-responsive nowrap" style="width: 100%">
                                <thead class="thead-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Member</th>
                                        <th>Nama Member</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>No Telp</th>
                                        <th>Poin</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $member->user_code }}</td>
                                            <td>{{ $member->name }}</td>
                                            <td>
                                                @if ($member->gender == 'L')
                                                    Laki-Laki
                                                @elseif ($member->gender == 'P')
                                                    Perempuan
                                                @else
                                                @endif
                                            </td>
                                            <td>{{ $member->address }}</td>
                                            <td>{{ $member->phone_number }}</td>
                                            <td>{{ $member->point }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Modal Tambah Member -->
                            <div class="modal fade" id="modalTambahMember" tabindex="-1" role="dialog"
                                aria-labelledby="modalTambahMemberLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('admin.members.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTambahMemberLabel">Tambah Member</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Tutup">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name">Nama</label>
                                                    <input type="text" name="name" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" name="email" class="form-control" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone_number">Nomor Telepon</label>
                                                    <input type="text" name="phone_number" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
            $('#tbl-members').DataTable();
        });
    </script>
@endsection
