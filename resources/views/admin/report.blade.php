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
                                    <a class="nav-link active text-blue-600" id="laporanKeuangan-tab" data-toggle="tab"
                                        href="#laporanKeuangan" role="tab" aria-controls="laporanKeuangan"
                                        aria-selected="true">Laporan Transaksi Perbulan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="analisisLayananDanPerilaku-tab" data-toggle="tab"
                                        href="#analisisLayananDanPerilaku" role="tab"
                                        aria-controls="analisisLayananDanPerilaku" aria-selected="false">Laporan Analisis Kepuasan Pelanggan</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="laporanKeuangan" role="tabpanel"
                                    aria-labelledby="laporanKeuangan-tab">
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
                                <div class="tab-pane fade show" id="analisisLayananDanPerilaku" role="tabpanel"
                                    aria-labelledby="analisisLayananDanPerilaku-tab">
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <form action="{{ route('admin.reports.printAnalysis') }}" method="post"
                                                target="_blank">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="tahun" class="col-sm-2 col-form-label">Tahun</label>
                                                    <div class="col-sm-8">
                                                        <select class="form-control" id="tahun2" name="year">
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
                                                    <label for="bulan_awal" class="col-sm-2 col-form-label">Dari
                                                        Bulan</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="bulan_awal" name="bulan_awal"
                                                            disabled>
                                                            <option value="0" selected disabled>-- Silahkan Pilih Bulan
                                                                --</option>
                                                        </select>
                                                    </div>

                                                    <label for="bulan_akhir" class="col-form-label">-</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control" id="bulan_akhir" name="bulan_akhir"
                                                            disabled>
                                                            <option value="0" selected disabled>-- Silahkan Pilih
                                                                Bulan --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" id="btn-cetak2"
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
    {{-- <script>
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
                            $('#bulan_awal, #bulan_akhir').empty().append(
                                '<option selected disabled>-- Silahkan Pilih Bulan --</option>'
                            ).prop('disabled', false);

                            $.each(data, function(key, value) {
                                $('#bulan_awal').append('<option value="' + value
                                    .Bulan + '">' + getMonthName(value.Bulan) +
                                    '</option>');
                                $('#bulan_akhir').append('<option value="' + value
                                    .Bulan + '">' + getMonthName(value.Bulan) +
                                    '</option>');
                            });

                            $('#btn-cetak2').removeClass('d-none');
                        }
                    });
                }
            });
        });

        function getMonthName(monthNumber) {
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];
            return monthNames[monthNumber - 1];
        }
    </script> --}}
@endsection
