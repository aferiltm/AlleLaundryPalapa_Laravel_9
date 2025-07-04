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
                    <h1 class="m-0 text-dark">Review</h1>
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
                            <h5>Daftar Review</h5>
                            <div class="row">
                                <div class="col-sm-6">

                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Rating</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($review as $r)
                                                <tr>
                                                    <td>{{ $r->transaction->transaction_code }}</td>
                                                    <td>{{ $r->user->name }}</td>
                                                    <td>
                                                        @for ($i = 0; $i < ($r->rating ?? 0); $i++)
                                                            ⭐
                                                        @endfor
                                                    </td>
                                                    {{-- <td>{{ $r->review }}</td> --}}
                                                    <td>
                                                        {{-- <button href="#" class="badge badge-success lihat-isi"
                                                            data-id="{{ $r->id }}">Lihat isi
                                                            komplain</button> --}}
                                                        <button href="#"
                                                            class="bg-yellow-500 hover:bg-yellow-900 duration-200 text-white rounded text-base px-2 py-1 lihat-isi"
                                                            data-id="{{ $r->id }}"
                                                            data-kode="{{ $r->transaction->transaction_code }}"
                                                            data-review="{{ $r->review }}"
                                                            data-reply="{{ $r->reply }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>


                                                        {{-- <button href="#" class="bg-re-600 hover:bg-re-900 duration-200 text-white rounded text-base px-2 py-2 btn-update-cost"
                                                        data-id="{{ $r->id }}">Lihat isi
                                                        komplain</button> --}}
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
                                    <div class="form-group">
                                        <label for="kode_transaksi">Kode Transaksi</label>
                                        <textarea class="form-control" id="kode_transaksi" rows="1" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="isi-review">Review</label>
                                        <textarea class="form-control" id="isi-review" rows="3" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="balas">Balas</label>
                                        <textarea class="form-control" id="balas" rows="3" disabled></textarea>
                                    </div>
                                    <button id="btn-kirim-balasan" class="btn text-white bg-blue-900 hover:bg-blue-950" data-id="">Kirim</button>
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
    {{-- <script src="{{ asset('js/ajax-saran.js') }}"></script> --}}
    <script>
        $('.lihat-isi').on('click', function() {
            const id = $(this).data('id');
            const kode = $(this).data('kode');
            const review = $(this).data('review');
            const reply = $(this).data('reply');

            $('#kode_transaksi').val(kode);
            $('#isi-review').val(review);
            $('#balas').val(reply).prop('disabled', false);
            $('#btn-kirim-balasan').data('id', id);
        });

        $('#btn-kirim-balasan').on('click', function() {
            const id = $(this).data('id'); // Ambil ID dari tombol
            const balasan = $('#balas').val(); // Ambil isi textarea

            if (!id || !balasan) {
                alert('ID atau balasan kosong.');
                return;
            }

            $.ajax({
                url: '/admin/review/' + id,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PATCH',
                    balasan: balasan
                },
                success: function() {
                    alert('Balasan berhasil dikirim');
                    location.reload();
                },
                error: function(xhr) {
                    alert('Gagal mengirim balasan');
                    console.error(xhr.responseText); // Lihat detail error di console
                }
            });
        });
    </script>
@endsection
