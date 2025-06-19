@extends('admin.template.main')

@section('css')
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/662346788c.js" crossorigin="anonymous"></script>
    {{-- Trailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Bootstrap --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
@endsection

@section('main-content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Selamat Datang Admin, {{ $user->name }}</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <p>Jumlah Member</p>

                            <h3>{{ $membersCount }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-user-group" style="font-size:500%;"></i>
                        </div>
                        <a href="{{ route('admin.members.index') }}" class="small-box-footer">Lihat member <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-yellow-500 text-white">
                        <div class="inner">
                            <p class="text-white">Transaksi Berjalan</p>

                            <h3>{{ $transactionsRunCount ?? 0 }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-gears" style="font-size:500%;"></i>
                        </div>
                        <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">Lihat transaksi Berjalan
                            <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <p>Transaksi Selesai</p>

                            <h3>{{ $completedTransactionsCount }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fa-regular fa-circle-check" style="font-size:500%;"></i>
                        </div>
                        <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">Lihat transaksi selesai
                            <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <p>Jumlah Transaksi</p>

                            <h3>{{ $transactionsCount }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-bag-shopping" style="font-size:500%;"></i>
                        </div>
                        <a href="{{ route('admin.transactions.index') }}" class="small-box-footer">Lihat transaksi <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                {{-- <div class="col-3">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <p>Jumlah Member</p>

                            <h3>{{ $membersCount }}</h3>
                        </div>
                        <div class="icon">
                            <i class="fa-solid fa-user-group" style="font-size:500%;"></i>
                        </div>
                        <a href="{{ route('admin.members.index') }}" class="small-box-footer">Lihat member <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div> --}}
            </div>

            <div class="row">
                <div class="col">
                    <div class="card mb-3">
                        <div class="p-3">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p><b>Data Pendapatan</b></p>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="periodFilter">Pilih Periode:</label>
                                            <select id="periodFilter" class="form-control">
                                                <option value="monthly" selected>Per Bulan</option>
                                                <option value="yearly">Per Tahun</option>
                                            </select>
                                        </div>
                                        <div class="col-6 d-none" id="yearRange">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>Dari Tahun:</label>
                                                    <input type="number" id="startYear" class="form-control" min="2000"
                                                        max="{{ date('Y') }}" value="{{ date('Y') - 4 }}">
                                                </div>
                                                <div class="col-6">
                                                    <label>Sampai Tahun:</label>
                                                    <input type="number" id="endYear" class="form-control" min="2000"
                                                        max="{{ date('Y') }}" value="{{ date('Y') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="revenueChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card mb-3">
                        <div class="p-3">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <p><b>Data Transaksi Masuk</b></p>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="filterPeriod">Pilih Periode</label>
                                            <select id="filterPeriod" class="form-control">
                                                <option value="monthly">Per Bulan</option>
                                                <option value="yearly">Per Tahun</option>
                                            </select>
                                        </div>
                                        <div id="yearRangeInputs" class="col-6" style="display: none;">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="startYear">Dari Tahun</label>
                                                    <input type="number" id="startYearT" class="form-control"
                                                        value="2021" min="2000">
                                                </div>
                                                <div class="col-6">
                                                    <label for="endYear">Sampai Tahun</label>
                                                    <input type="number" id="endYearT" class="form-control"
                                                        value="2025" min="2000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <canvas id="transactionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class=row>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4>Transaksi Berjalan</h4>
                            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active text-blue-600" id="kilatService-tab" data-toggle="tab"
                                        href="#kilatService" role="tab" aria-controls="kilatService"
                                        aria-selected="true">Kilat Service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="expressService-tab" data-toggle="tab"
                                        href="#expressService" role="tab" aria-controls="expressService"
                                        aria-selected="true">Express Service</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-blue-600" id="regulerService-tab" data-toggle="tab" href="#regulerService"
                                        role="tab" aria-controls="regulerService" aria-selected="false">Reguler
                                        Service</a>
                                </li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="kilatService" role="tabpanel"
                                    aria-labelledby="kilatService-tab">
                                    <table id="tbl-transaksi-kilat" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Estimasi Selesai</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kilatTransactions as $transaction)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $transaction->transaction_code }}</td>
                                                    <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                                                    <td>{{ date('d F Y', strtotime($transaction->estimated_finish_at)) }}</td>
                                                    <td>
                                                        @if ($transaction->status_id == 3)
                                                            <span
                                                                class="p-1 bg-success text-white rounded">{{ $transaction->status->name }}</span>
                                                        @elseif ($transaction->status_id == 2)
                                                            <span
                                                                class="p-1 bg-warning text-white rounded">{{ $transaction->status->name }}</span>
                                                        @else
                                                            <span
                                                                class="p-1 bg-danger text-white rounded">{{ $transaction->status->name }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="expressService" role="tabpanel"
                                    aria-labelledby="expressService-tab">
                                    <table id="tbl-transaksi-express" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Estimasi Selesai</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($expressTransactions as $transaction)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $transaction->transaction_code }}</td>
                                                    <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                                                    <td>{{ date('d F Y', strtotime($transaction->estimated_finish_at)) }}</td>
                                                    <td>
                                                        @if ($transaction->status_id == 3)
                                                            <span
                                                                class="p-1 bg-success text-white rounded">{{ $transaction->status->name }}</span>
                                                        @elseif ($transaction->status_id == 2)
                                                            <span
                                                                class="p-1 bg-warning text-white rounded">{{ $transaction->status->name }}</span>
                                                        @else
                                                            <span
                                                                class="p-1 bg-danger text-white rounded">{{ $transaction->status->name }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="regulerService" role="tabpanel"
                                    aria-labelledby="regulerService-tab">
                                    <table id="tbl-transaksi-reguler" class="table dataTable dt-responsive nowrap"
                                        style="width:100%">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Transaksi</th>
                                                <th>Tanggal</th>
                                                <th>Estimasi Selesai</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($recentTransactions as $transaction)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $transaction->transaction_code }}</td>
                                                    <td>{{ date('d F Y', strtotime($transaction->created_at)) }}</td>
                                                    <td>{{ date('d F Y', strtotime($transaction->estimated_finish_at)) }}</td>
                                                    <td>
                                                        @if ($transaction->status_id == 3)
                                                            <span
                                                                class="p-1 bg-success text-white rounded">{{ $transaction->status->name }}</span>
                                                        @elseif ($transaction->status_id == 2)
                                                            <span
                                                                class="p-1 bg-warning text-white rounded">{{ $transaction->status->name }}</span>
                                                        @else
                                                            <span
                                                                class="p-1 bg-danger text-white rounded">{{ $transaction->status->name }}</span>
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
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>

    {{-- Menampilkan Chart Revenue/Pendapatan --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                        label: 'Pendapatan',
                        data: [],
                        borderColor: '#3329aa',
                        backgroundColor: '#5b5bf9',
                        borderWidth: 1,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const periodFilter = document.getElementById('periodFilter');
            const yearRange = document.getElementById('yearRange');
            const startYear = document.getElementById('startYear');
            const endYear = document.getElementById('endYear');

            function fetchRevenueData() {
                let period = periodFilter.value;
                let url = `{{ route('admin.revenue.data') }}?period=${period}`;

                if (period === 'yearly') {
                    url += `&start_year=${startYear.value}&end_year=${endYear.value}`;
                }

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.length) {
                            console.error("Tidak ada data untuk ditampilkan!");
                            return;
                        }

                        const labels = data.map(item => item.month ?? item.year);
                        const revenueData = data.map(item => item.total);

                        revenueChart.data.labels = labels;
                        revenueChart.data.datasets[0].data = revenueData;
                        revenueChart.update();
                    })
                    .catch(error => console.error("Gagal mengambil data: ", error));
            }

            periodFilter.addEventListener('change', function() {
                yearRange.classList.toggle('d-none', this.value !== 'yearly');
                fetchRevenueData();
            });

            startYear.addEventListener('change', fetchRevenueData);
            endYear.addEventListener('change', fetchRevenueData);

            // Load default data
            fetchRevenueData();
        });
    </script>

    {{-- Menampilakan Chart Data Transaksi --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.transactionChart = null;

            async function fetchTransactionData(period, startYear = null, endYear = null) {
                let url = `{{ route('admin.transaksi.data') }}?period=${period}`;
                if (period === "yearly" && startYear && endYear) {
                    url += `&start_year=${startYear}&end_year=${endYear}`;
                }

                const response = await fetch(url);
                return response.json();
            }

            async function updateTransactionChart() {
                const period = document.getElementById('filterPeriod').value;
                const startYearT = document.getElementById('startYearT').value;
                const endYearT = document.getElementById('endYearT').value;
                const data = await fetchTransactionData(period, startYearT, endYearT);

                const ctx = document.getElementById('transactionChart').getContext('2d');

                if (window.transactionChart) {
                    window.transactionChart.destroy();
                }

                window.transactionChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                                label: 'Transaksi Reguler',
                                data: data.regular,
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                fill: true
                            },
                            {
                                label: 'Transaksi Express',
                                data: data.express,
                                borderColor: 'rgba(255, 99, 132, 1)',
                                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                fill: true
                            },
                            {
                                label: 'Transaksi Kilat',
                                data: data.kilat,
                                borderColor: 'rgb(33, 194, 71)',
                                backgroundColor: 'rgb(33, 255, 149)',
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                display: true
                            }
                        }
                    }
                });
            }

            document.getElementById('filterPeriod').addEventListener('change', function() {
                const yearInputs = document.getElementById('yearRangeInputs');
                if (this.value === 'yearly') {
                    yearInputs.style.display = 'block';
                } else {
                    yearInputs.style.display = 'none';
                }
                updateTransactionChart();
            });

            document.getElementById('startYearT').addEventListener('input', updateTransactionChart);
            document.getElementById('endYearT').addEventListener('input', updateTransactionChart);

            updateTransactionChart();
        });
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            let tabs = document.querySelectorAll(".nav-link");

            tabs.forEach((tab) => {
                tab.addEventListener("click", function() {
                    tabs.forEach((el) => {
                        el.classList.remove("text-blue-600");
                    });
                    this.classList.add("text-blue-600");
                });
            });

            // Set warna biru untuk tab yang aktif saat halaman pertama kali dimuat
            let activeTab = document.querySelector(".nav-link.active");
            if (activeTab) {
                activeTab.classList.add("text-blue-600");
            }
        });
    </script> --}}
@endsection

{{-- @section('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/ajax.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#tbl-transaksi-reguler').DataTable();
            $('#tbl-transaksi-priority').DataTable();
        });
    </script>
@endsection --}}
