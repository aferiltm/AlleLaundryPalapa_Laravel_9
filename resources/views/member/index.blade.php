@extends('member.template.main')

@section('css')
    <script src="https://cdn.tailwindcss.com"></script>
@endsection
@section('main-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard Member</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <img class="img-circle img-fit float-left" width="100" height="100"
                                        src="{{ $user->getFileAsset() }}" alt="Foto Profil">
                                    <div class="member-content">
                                        <h2 class="m-0 text-lg">{{ $user->name }}</h2>
                                        <p class="small m-1 text-base mb-2">ID Member: {{ $user->id }}</p>
                                        <a href="{{ route('profile.index') }}"
                                            class="bg-stone-600 hover:bg-stone-900 duration-200 text-white rounded-full py-1 px-2 mt-2">Edit
                                            Profil</a>
                                    </div>
                                </div>
                                <div class="col-3 text-center">
                                    <p class="small m-0">
                                    <h5 class="mb-2 text-lg">Poin</h5>
                                    </p>
                                    <h2 class="m-0 mb-3 text-xl">{{ $user->point }}</h2>
                                    {{-- <a href="{{ route('member.points.index') }}"
                                        class="badge badge-success badge-pill">Tukar
                                        Poin</a> --}}
                                    <a href="{{ route('member.points.index') }}"
                                        class="bg-yellow-600 hover:bg-yellow-900 duration-200 text-white rounded-full py-2 px-2 mt-2">Tukar
                                        Poin</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5>Telepon atau Chat:</h5>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Instagram</td>
                                                <td>#####</td>
                                            </tr>
                                            <tr>
                                                <td>Whatsapp</td>
                                                <td>0813-8300-4378</td>
                                            </tr>
                                            <tr>
                                                <td>Telepon</td>
                                                <td>######</td>
                                            </tr>
                                            <tr>
                                                <td>Hanya melayani saat jam kerja</td>
                                                <td>
                                                    Senin - Jumat (07:00 - 19:00 WIB)<br>
                                                    Sabtu - Minggu (08:00 - 16:00 WIB)
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mt-2">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="my-3 text-center">Transaksi Terakhir</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
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
                                    @foreach ($latestTransactions as $item)
                                        <tr>
                                            <td style="padding-top: 20px;">{{ $loop->iteration }}</td>
                                            <td style="padding-top: 20px;">{{ $item->transaction_code }}</td>
                                            <td style="padding-top: 20px;">
                                                {{ date('d F Y', strtotime($item->created_at)) }}
                                            </td>
                                            <td style="padding-top: 20px;">
                                                @if ($item->status_id == 3)
                                                    <span
                                                        class="p-1 bg-success text-white rounded">{{ $item->status->name }}</span>
                                                @elseif ($item->status_id == 2)
                                                    <span
                                                        class="p-1 bg-warning text-white rounded">{{ $item->status->name }}</span>
                                                @else
                                                    <span
                                                        class="p-1 bg-danger text-white rounded">{{ $item->status->name }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('member.transactions.show', ['transaction' => $item->id]) }}"
                                                    class="btn btn-primary"><i class="fa-solid fa-circle-info"></i></a>
                                            </td>
                                            <td>
                                                @if ($item->status_id == 3)
                                                    @if ($item->hasReview())
                                                        <button class="btn btn-secondary" disabled>
                                                            Ulasan <i class="fa-solid fa-star"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-success" data-toggle="modal"
                                                            data-target="#reviewModal{{ $item->id }}">
                                                            Ulasan <i class="fa-solid fa-star"></i>
                                                        </button>
                                                    @endif

                                                    @if ($item->hasFeedback())
                                                        <button class="btn bg-gray-500 text-white" disabled>
                                                            Sudah Komplain <i class="fa-solid fa-circle-check"></i>
                                                        </button>
                                                    @else
                                                        <button class="btn btn-warning" data-toggle="modal"
                                                            data-target="#formSaranKomplainModal{{ $item->id }}">
                                                            Beri Saran/Komplain <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    @endif
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

    @foreach ($latestTransactions as $item)
        <!-- Modal Ulasan -->
        <div class="modal fade" id="reviewModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="reviewModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel{{ $item->id }}">Beri Ulasan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('member.review.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <p class="mb-3 font-semibold"><span class="text-red-500">*</span>Sebelum mengisi ulasan harap
                                periksa laundry anda, Terima Kasih</p>
                            <input type="hidden" name="transaction_id" value="{{ $item->id }}">
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Kirim Ulasan <i
                                    class="fa-solid fa-paper-plane"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($latestTransactions as $item)
        <!-- Modal Saran atau Komplain -->
        <div class="modal fade" id="formSaranKomplainModal{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="formSaranKomplainLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form method="POST" action="{{ route('member.complaints.store') }}">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header bg-warning text-white">
                            <h5 class="modal-title" id="formSaranKomplainLabel{{ $item->id }}">Beri Saran atau
                                Komplain</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-sm">
                            <input type="hidden" name="transaction_id" value="{{ $item->id }}">

                            <div class="form-group">
                                <label for="type">Tipe</label>
                                <select name="type" id="type-{{ $item->id }}" class="form-control" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="Saran">Saran</option>
                                    <option value="Komplain">Komplain</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="feedback">Isi Feedback</label>
                                <textarea name="feedback" id="feedback-{{ $item->id }}" class="form-control" rows="4" required></textarea>
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
    @endforeach
@endsection
