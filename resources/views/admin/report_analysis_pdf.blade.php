<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Analisis Layanan, Kepuasan, dan Pendapatan Alle Laundry Palapa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        #myChart {
            width: 400px;
            height: 400px;
            margin: 30px auto;
        }
    </style>
    {{-- <style>
        @page {
            size: A4;
            margin: 20mm 15mm 20mm 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        h2, h4, p {
            margin: 0;
            padding: 8px 0;
        }

        section {
            page-break-inside: avoid;
            margin-bottom: 30px;
        }

        img {
            max-width: 400px;
            height: auto;
            margin: 30px auto;
            display: block;
        }

        /* Footer for page number */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20mm;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .pagenum:before {
            content: counter(page);
        }
    </style> --}}
</head>

<body>
    <h2 style="text-align: center;">Laporan Pendapatan dan Analisis Kepuasan Layanan pada Laundry</h2>
    <p style="text-align: center;">Periode: {{ $namaBulanAwal }} - {{ $namaBulanAkhir }} {{ $tahun }}</p>

    <section>
        <h4>A. Laporan Rating Layanan dan Kepuasan Pelanggan</h4>
        <table>
            <thead>
                <tr>
                    <th>Rating</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td>Rating {{ $i }}</td>
                        <td>{{ $data[$i] }}</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $chartUrlRatings }}" alt="Pie Chart" style="max-width: 400px; height: auto;">
        </div>
    </section>
    <section>
        <h4>B. Laporan Transaksi Reguler, Express, dan Kilat</h4>
        {{-- Table data --}}
        <table>
            <thead>
                <tr>
                    <th>Jenis Transaksi</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Reguler</td>
                    <td>{{ $transactionData['Regular'] }}</td>
                </tr>
                <tr>
                    <td>Express</td>
                    <td>{{ $transactionData['Express'] }}</td>
                </tr>
                <tr>
                    <td>Kilat</td>
                    <td>{{ $transactionData['Kilat'] }}</td>
                </tr>
            </tbody>
        </table>
        {{-- Pie Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $transactionChartUrl }}" alt="Transaction Pie Chart" style="max-width: 400px; height: auto;">
        </div>
        {{-- Line Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $transactionLineChartUrl }}" alt="Transaction Line Chart"
                style="max-width: 400px; height: auto;">
        </div>
    </section>
    <section>
        <h4>C. Laporan Voucher</h4>
        {{-- Line Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $voucherLineChartUrl }}" alt="Transaction Line Chart" style="max-width: 400px; height: auto;">
        </div>
    </section>
    <section>
        <h4>D. Laporan Komplain</h4>
        {{-- Line Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $complaintLineChartUrl }}" alt="Transaction Line Chart"
                style="max-width: 400px; height: auto;">
        </div>
        <p>Jumlah Komplain : {{ array_sum($complaintLineChartData) }}</p>
    </section>
    <section>
        <h4>E. Laporan Pendapatan</h4>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Pendapatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($revenueData as $month => $revenue)
                    <tr>
                        <td>{{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }}</td>
                        <td>Rp {{ number_format($revenue, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Line Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $revenueLineChartUrl }}" alt="Revenue Line Chart" style="max-width: 400px; height: auto;">
        </div>
    </section>
    <section>
        <h4>E. Laporan banyaknya pesanan Kiloan dan Satuan</h4>
        {{-- Table Data --}}
        <table>
            <thead>
                <tr>
                    <th>Jenis Pesanan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kiloan</td>
                    <td>{{ $kiloanCount }}</td>
                </tr>
                <tr>
                    <td>Satuan</td>
                    <td>{{ $satuanCount }}</td>
                </tr>
            </tbody>
        </table>
        {{-- Pie Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $pieChartUrlKL }}" alt="Pie Chart Pesanan" style="max-width: 400px; height: auto;">
        </div>
        {{-- Line Chart --}}
        <div style="text-align: center; margin-top: 30px;">
            <img src="{{ $lineChartUrlKL }}" alt="Line Chart Pesanan" style="max-width: 400px; height: auto;">
        </div>
    </section>

    <!-- Footer -->

</body>

</html>
