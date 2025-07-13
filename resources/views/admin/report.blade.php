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
                    <h1 class="m-0 text-dark">Buat Laporan</h1>
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

                            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-blue-600" id="laporanTransaksi-tab" data-toggle="tab"
                                        href="#laporanTransaksi" role="tab" aria-controls="laporanTransaksi"
                                        aria-selected="true">Laporan Transaksi Perbulan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="laporanKomplain-tab" data-toggle="tab"
                                        href="#laporanKomplain" role="tab" aria-controls="laporanKomplain"
                                        aria-selected="false">Laporan Komplain</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="laporanMember-tab" data-toggle="tab"
                                        href="#laporanMember" role="tab" aria-controls="laporanMember"
                                        aria-selected="false">Laporan Member</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="laporanTransaksi" role="tabpanel"
                                    aria-labelledby="laporanTransaksi-tab">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <form action="{{ route('admin.reports.print') }}" method="post"
                                                target="_blank">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="tahun" class="col-sm-4 col-form-label">Tahun</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="tahun" name="year">
                                                            <option value="0" selected="selected" disabled="true">--
                                                                Silahkan
                                                                Pilih Tahun
                                                                --</option>
                                                            @foreach ($years as $year)
                                                                <option value="{{ $year->Tahun }}">{{ $year->Tahun }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="bulan" class="col-sm-4 col-form-label">Bulan</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="bulan" name="month">
                                                            <option value="0" selected="selected" disabled="true">--
                                                                Silahkan
                                                                Pilih Bulan --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" id="btn-cetak"
                                                    class="mt-3 btn btn-success d-none">Cetak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Komplain -->
                                <div class="tab-pane fade" id="laporanKomplain" role="tabpanel"
                                    aria-labelledby="laporanKomplain-tab">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <form action="{{ route('admin.reports.printKomplain') }}" method="post"
                                                target="_blank">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="tahun-komplain"
                                                        class="col-sm-4 col-form-label">Tahun</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="tahun-komplain" name="year">
                                                            <option selected disabled>-- Pilih Tahun --</option>
                                                            @foreach ($years as $year)
                                                                <option value="{{ $year->Tahun }}">{{ $year->Tahun }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="bulan-komplain"
                                                        class="col-sm-4 col-form-label">Bulan</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="bulan-komplain" name="month">
                                                            <option selected disabled>-- Pilih Bulan --</option>
                                                            @for ($m = 1; $m <= 12; $m++)
                                                                <option value="{{ $m }}">
                                                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" id="btn-cetak-komplain"
                                                    class="mt-3 btn btn-success d-none">Cetak</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Laporan Member -->
                                <div class="tab-pane fade" id="laporanMember" role="tabpanel"
                                    aria-labelledby="laporanMember-tab">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <form action="{{ route('admin.reports.printMember') }}" method="post"
                                                target="_blank">
                                                @csrf

                                                <!-- ✅ Tambahkan kembali dropdown Tahun -->
                                                <div class="form-group row">
                                                    <label for="tahun-member"
                                                        class="col-sm-4 col-form-label">Tahun</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="tahun-member" name="year"
                                                            required>
                                                            <option selected disabled>-- Pilih Tahun --</option>
                                                            @foreach ($years as $year)
                                                                <option value="{{ $year->Tahun }}">{{ $year->Tahun }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Sudah benar bagian Bulan -->
                                                <div class="form-group row">
                                                    <label for="bulan-member"
                                                        class="col-sm-4 col-form-label">Bulan</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" id="bulan-member" name="month"
                                                            required>
                                                            <option selected disabled>-- Pilih Bulan --</option>
                                                            @for ($m = 1; $m <= 12; $m++)
                                                                <option value="{{ $m }}">
                                                                    {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                                                </option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>

                                                <button type="submit" id="btn-cetak-member"
                                                    class="mt-3 btn btn-success d-none">Cetak</button>
                                            </form>
                                        </div>
                                    </div>
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
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#tahun2').change(function() {
                var year = $(this).val();
                if (year) {
                    $.ajax({
                        url: '{{ route('admin.reports.getMonth') }}',
                        type: 'GET',
                        data: {
                            year: year
                        },
                        success: function(data) {
                            // Kosongkan dropdown bulan
                            $('#bulan_awal').empty().append(
                                '<option selected disabled>-- Silahkan Pilih Bulan --</option>'
                            );
                            $('#bulan_akhir').empty().append(
                                '<option selected disabled>-- Silahkan Pilih Bulan --</option>'
                            );

                            // Aktifkan select bulan
                            $('#bulan_awal').prop('disabled', false);
                            $('#bulan_akhir').prop('disabled', false);

                            // Isi dropdown dengan data dari server
                            $.each(data, function(key, value) {
                                $('#bulan_awal').append('<option value="' + value
                                    .Bulan + '">' + getMonthName(value.Bulan) +
                                    '</option>');
                                $('#bulan_akhir').append('<option value="' + value
                                    .Bulan + '">' + getMonthName(value.Bulan) +
                                    '</option>');
                            });

                            // Tampilkan tombol cetak
                            $('#btn-cetak2').removeClass('d-none');
                        }
                    });
                }
            });
        });

        // Fungsi untuk konversi angka bulan ke nama bulan Indonesia
        function getMonthName(monthNumber) {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return monthNames[monthNumber - 1];
        }
    </script>

    <script>
        const tahunInput = document.getElementById('tahun-komplain');
        const bulanInput = document.getElementById('bulan-komplain');
        const btnCetak = document.getElementById('btn-cetak-komplain');

        function toggleButton() {
            const tahun = tahunInput.value;
            const bulan = bulanInput.value;
            btnCetak.classList.toggle('d-none', !(tahun && bulan));
        }

        tahunInput.addEventListener('change', toggleButton);
        bulanInput.addEventListener('change', toggleButton);
    </script>
    <script>
        const tahunInput2 = document.getElementById('tahun-member');
        const btnCetak2 = document.getElementById('btn-cetak-member');

        tahunInput2.addEventListener('change', function() {
            btnCetak2.classList.remove('d-none');
        });
    </script>
    <script>
        const tahunMember = document.getElementById('tahun-member');
        const bulanMember = document.getElementById('bulan-member');
        const btnMember = document.getElementById('btn-cetak-member');

        function toggleCetakMember() {
            const year = tahunMember.value;
            const month = bulanMember.value;
            btnMember.classList.toggle('d-none', !(year && month));
        }

        tahunMember.addEventListener('change', toggleCetakMember);
        bulanMember.addEventListener('change', toggleCetakMember);
    </script>
@endsection
