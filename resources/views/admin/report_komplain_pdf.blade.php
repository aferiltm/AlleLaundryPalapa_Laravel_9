<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Komplain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <style>
        table,
        th,
        td {
            border: 1px solid #000;
        }

        th,
        td {
            padding: 6px;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <header class="text-center my-3">
        <div class="row">
            <div class="col-12">
                <h2>Kantil Laundry</h2>
                <h5>Laporan Komplain Pelanggan</h5>
                <p>Bulan {{ $month }} Tahun {{ $yearInput }}</p>
            </div>
        </div>
    </header>

    <table class="table table-bordered table-sm">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Feedback</th>
                <th>Reply</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($complaints as $index => $print)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $print->user->name ?? '-' }}</td>
                    <td>{{ $print->feedback }}</td>
                    <td>{{ $print->reply ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($print->created_at)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data komplain pada bulan ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <footer class="text-end mt-4">
        <span class="text-muted small">Dicetak di Jakarta, {{ \Carbon\Carbon::now()->format('d M Y') }}</span>
    </footer>

</body>

</html>
