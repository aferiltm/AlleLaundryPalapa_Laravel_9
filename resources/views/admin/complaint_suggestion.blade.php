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
                                    <h6 class="text-danger">Belum Dibalas ({{ $count }})</h6>
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($complaints as $complaint)
                                                <tr class="bg-red-500">
                                                    <td>
                                                        @if ($complaint->transaction)
                                                            {{ $complaint->transaction->transaction_code }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $complaint->user->name }}</td>
                                                    <td>Komplain</td>
                                                    <td>
                                                        <button href="#"
                                                            class="bg-yellow-500 hover:bg-yellow-900 duration-200 text-white rounded text-base px-2 py-1 lihat-isi"
                                                            data-id="{{ $complaint->id }}"><i
                                                                class="fa-solid fa-eye"></i></button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach ($suggestions as $suggestion)
                                                <tr>
                                                    <td>
                                                        @if ($suggestion->transaction)
                                                            {{ $suggestion->transaction->transaction_code }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td>{{ $suggestion->user->name }}</td>
                                                    <td>Saran</td>
                                                    <td>
                                                        {{-- <button href="#" class="badge badge-success lihat-isi"
                                                            data-id="{{ $suggestion->id }}">Lihat isi
                                                            saran</button> --}}
                                                        <button href="#"
                                                            class="bg-blue-500 hover:bg-blue-900 duration-200 text-white rounded text-base px-2 py-1 lihat-isi"
                                                            data-id="{{ $suggestion->id }}"><i
                                                                class="fa-solid fa-eye"></i></button>
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

                                    <h6 class="text-success mt-3">Sudah Dibalas</h6>
                                    <table class="table-sm table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Kode</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($repliedFeedbacks as $replied)
                                                <tr class="bg-light">
                                                    <td>{{ $replied->transaction->transaction_code }}</td>
                                                    <td>{{ $replied->user->name }}</td>
                                                    <td>{{ $replied->type == 1 ? 'Saran' : 'Komplain' }}</td>
                                                    {{-- <td>{{ Str::limit($replied->body, 30) }}</td> --}}
                                                    <td>
                                                        <button
                                                            class="lihat-isi rounded bg-gray-500 px-2 py-1 text-base text-white duration-200 hover:bg-gray-700"
                                                            data-id="{{ $replied->id }}">
                                                            <i class="fa-solid fa-eye"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if ($repliedFeedbacks->count() == 0)
                                                <tr>
                                                    <td colspan="4" class="text-muted text-center">Belum ada feedback
                                                        yang dibalas</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="kode_transaksi">Kode Transaksi</label>
                                        <textarea class="form-control" id="kode_transaksi" name="kode_transaksi" rows="1" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="isi-aduan">Feedback</label>
                                        <textarea class="form-control" id="isi-aduan" name="feedback" rows="3" disabled></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="balas">Balas</label>
                                        <textarea class="form-control" id="balas" name="reply" rows="3" disabled></textarea>
                                    </div>
                                    <button id="btn-kirim-balasan" class="btn btn-success" data-id="">Kirim</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/ajax-saran.js') }}"></script>
    {{-- <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            $('.lihat-isi').on('click', function() {
                const id = $(this).data('id');
                $.ajax({
                    url: '/complaint-suggestions/show/' + id,
                    method: 'GET',
                    dataType: 'json', // ✅ Tambahkan baris ini
                    success: function(res) {
                        $('#kode_transaksi').val(res.transaction ? res.transaction
                            .transaction_code : '-');
                        $('#isi-aduan').val(res.feedback);
                        $('#balas').val(res.reply ?? '');
                        $('#balas').prop('disabled', false);
                        $('#btn-kirim-balasan').data('id', res.id);
                    },
                    error: function(xhr) {
                        alert('Gagal mengambil data.');
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#btn-kirim-balasan').on('click', function() {
                const id = $(this).data('id');
                const balasan = $('#balas').val();

                if (!id || !balasan.trim()) {
                    alert('Balasan tidak boleh kosong!');
                    return;
                }

                $.ajax({
                    url: '/complaint-suggestions/' + id,
                    method: 'PATCH',
                    data: {
                        reply: balasan
                    },
                    success: function() {
                        alert('Balasan berhasil dikirim');

                        // Hapus baris dari tabel
                        $('button[data-id="' + id + '"]').closest('tr').remove();

                        // Kosongkan dan disable field
                        $('#kode_transaksi').val('');
                        $('#isi-aduan').val('');
                        $('#balas').val('').prop('disabled', true);
                        $('#btn-kirim-balasan').data('id', '');
                    },
                    error: function(xhr) {
                        alert('Gagal mengirim balasan');
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
@endsection
