<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Laporan Member - {{ $yearInput }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #999;
            padding: 6px 4px;
            text-align: left;
        }

        th {
            background: #eee;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center; margin-bottom:10px;">
        Laporan Member<br>
        <small>{{ $monthName }} {{ $yearInput }}</small>
    </h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Gender</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Tgl Daftar</th>
                <th>Point</th>
                <th>Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($members as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->user_code }}</td>
                    <td>{{ $m->name }}</td>
                    <td>
                        @switch($m->gender)
                            @case('L')
                                Laki‑Laki
                            @break

                            @case('P')
                                Perempuan
                            @break

                            @default
                                -
                        @endswitch
                    </td>
                    <td>{{ $m->address }}</td>
                    <td>{{ $m->phone_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($m->created_at)->translatedFormat('d F Y') }}</td>
                    <td>{{ $m->monthly_point }}</td>
                    <td>{{ $m->transactions_count }}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align:center;">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <p style="margin-top:20px;">Total Member Tahun {{ $yearInput }}: <strong>{{ $members->count() }}</strong></p>
        <p>Total Pelanggan Baru: <strong>{{ $totalNew }}</strong></p>
    </body>

    </html>
