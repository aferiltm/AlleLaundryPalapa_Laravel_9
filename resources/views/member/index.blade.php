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

            {{-- <section class="pakaian section" id="pakaian">
                <div class="bg-white h-auto">
                    <div class="mx-auto pb-10 pt-8">
                        <h1 class="font-semibold text-2xl text-cyan-600 text-center pb-3 sm:pb-3 md:pb-3 lg:pb-8">PROMO</h1>

                        <p class="text-center text-sm text-gray-400 pb-4">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Geser untuk lihat promo lain
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </p>

                        <div class="carousel flex w-full overflow-x-auto space-x-4 px-4 md:px-10">
                            @foreach ($vouchers as $voucher)
                                <div class="carousel-item flex-shrink-0 w-64">
                                    <div class="flex flex-col justify-between items-center text-center h-full border border-gray-300 rounded-lg bg-gray-200 shadow-md p-4 hover:border-blue-600 hover:text-blue-600 text-gray-600"
                                        data-aos="fade-up">
                                        <h1 class="font-semibold text-sm md:text-md text-black mb-4">
                                            {{ $voucher->details }}
                                        </h1>
                                        @guest
                                            <a href="{{ route('login.show') }}"
                                                class="bg-blue-900 hover:bg-black transition-colors duration-200 text-white rounded-full py-2 px-6 text-sm md:text-base">
                                                Klaim
                                            </a>
                                        @endguest

                                        @auth
                                            <a href="{{ route('member.points.index') }}"
                                                class="bg-blue-900 hover:bg-black transition-colors duration-200 text-white rounded-full py-2 px-6 text-sm md:text-base">
                                                Klaim
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <p class="text-center text-sm text-gray-400 pt-6">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            Geser untuk lihat promo lain
                            <i class="fa-solid fa-arrow-right ml-2"></i>
                        </p>
                    </div>
                </div>
            </section> --}}

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
                                            <td style="padding-top: 20px;">
                                                {{ date('d F Y', strtotime($item->created_at)) }}
                                            </td>
                                            <td style="padding-top: 20px;">
                                                {{-- @if ($item->status_id != '3')
                                                    <span class="text-danger">{{ $item->status->name }}</span>
                                                @else
                                                    <span class="text-success">{{ $item->status->name }}</span>
                                                @endif --}}
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
                    <form action="{{ route('member.complaints.store') }}" method="POST">
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
                                <label>Saran atau Komplain Laundry</label>
                                <select class="form-control" id="tipe" name="type">
                                    <option value="1">Saran/Kritik/Review</option>
                                    <option value="2">Komplain</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" id="form_sarankomplain" rows="4" name="feedback"></textarea>
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
@endsection
