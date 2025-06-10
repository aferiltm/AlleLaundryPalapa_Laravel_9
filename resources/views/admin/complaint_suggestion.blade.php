@extends('admin.template.main')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('admin') }}">
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>Daftar Saran atau Komplain</h5>
                            <div class="row">
                                <div class="col-sm-6">

                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Rating</th>
                                                <th>Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($complaints as $complaint)
                                                <tr class="bg-red-500">
                                                    <td>{{ $complaint->user->name }}</td>
                                                    <td>
                                                        @for ($i = 0; $i < ($complaint->rating ?? 0); $i++)
                                                            ⭐
                                                        @endfor
                                                    </td>
                                                    <td>Komplain</td>
                                                    <td>
                                                        {{-- <button href="#" class="badge badge-success lihat-isi"
                                                            data-id="{{ $complaint->id }}">Lihat isi
                                                            komplain</button> --}}
                                                            <button href="#" class="bg-yellow-500 hover:bg-yellow-900 duration-200 text-white rounded text-base px-2 py-1 lihat-isi"
                                                            data-id="{{ $complaint->id }}"><i class="fa-solid fa-eye"></i></button>

                                                        {{-- <button href="#" class="bg-re-600 hover:bg-re-900 duration-200 text-white rounded text-base px-2 py-2 btn-update-cost"
                                                        data-id="{{ $complaint->id }}">Lihat isi
                                                        komplain</button> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach ($suggestions as $suggestion)
                                                <tr>
                                                    <td>{{ $suggestion->user->name }}</td>
                                                    <td>
                                                        @for ($i = 0; $i < ($suggestion->rating ?? 0); $i++)
                                                            ⭐
                                                        @endfor
                                                    </td>
                                                    <td>Saran</td>
                                                    <td>
                                                        {{-- <button href="#" class="badge badge-success lihat-isi"
                                                            data-id="{{ $suggestion->id }}">Lihat isi
                                                            saran</button> --}}
                                                            <button href="#" class="bg-blue-500 hover:bg-blue-900 duration-200 text-white rounded text-base px-2 py-1 lihat-isi"
                                                            data-id="{{ $suggestion->id }}"><i class="fa-solid fa-eye"></i></button>
                                                        </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" style="border-bottom: 1px solid #ccc;"></td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Jumlah</td>
                                                <td>{{ $count }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    {{-- <div class="form-group">
                                        <label for="isi-review">Review</label>
                                        <textarea class="form-control" id="isi-review" rows="3" readonly></textarea>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="kode_transaksi">Kode Transaksi</label>
                                        <textarea class="form-control" id="kode_transaksi" rows="1" disabled></textarea>
                                    </div>
                                    {{-- <div class="form-group">
                                        <label for="category">Kategori</label>
                                        <textarea class="form-control" id="category" rows="1" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="total_harga">Total Harga</label>
                                        <textarea class="form-control" id="total_harga" rows="1" disabled></textarea>
                                    </div> --}}
                                    <div class="form-group">
                                        <label for="isi-aduan">Feedback</label>
                                        <textarea class="form-control" id="isi-aduan" rows="3" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="balas">Balas</label>
                                        <textarea class="form-control" id="balas" rows="3" disabled></textarea>
                                    </div>
                                    <button id="btn-kirim-balasan" class="btn btn-success" data-id="">Kirim</button>
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
    <script src="{{ asset('js/ajax-saran.js') }}"></script>
@endsection
