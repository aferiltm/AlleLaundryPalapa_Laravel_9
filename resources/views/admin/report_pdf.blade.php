<!DOCTYPE html>
<html lang="en">

<head>
    <title>Laporan Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }
    </style>
</head>

<body>

    <header class="text-center">
        <div class="row">
            <div class="col-4">
                <h1>{{ config('app.name') }}</h1>
            </div>
            <div class="col-4">
                <h3>Laporan Transaksi Bulan {{ $monthInput }} Tahun {{ $yearInput }}</h3>
            </div>
            <div class="col-4">
            </div>
        </div>
    </header>
    <br>
    {{-- <div class="text-left">
        <span class="text-muted small text-end">Dicetak pada Surakarta, {{ date('d M Y') }}</span>
    </div> --}}
    <hr>
    <main>
        <p>Banyak transaksi: {{ $transactionsCount }} transaksi</p>
        <p>Total pendapatan: Rp {{ number_format($revenue, 0, ',', '.') }}</p>
    </main>
    <hr>
    <table class="w-full text-xs">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Transaksi</th>
                <th>No Telp</th>
                <th>Jenis Pesanan</th>
                <th>Alamat</th>
                <th>Sub Total</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $print)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $print->transaction_code }}</td>
                    <td>{{ $print->member->phone_number }}</td>
                    <td>
                        @if ($print->transaction_details->isNotEmpty())
                            @foreach ($print->transaction_details as $detail)
                                {{ $detail->price_list->category->name }}<br>
                            @endforeach
                        @elseif ($print->transaction_details_kiloan->isNotEmpty())
                            @foreach ($print->transaction_details_kiloan as $detail)
                                {{ $detail->price_list_kiloan->category_kiloan->name }}<br>
                            @endforeach
                        @else
                            Tidak ada jenis pesanan
                        @endif
                    </td>
                    <td>{{ $print->member->address }}</td>
                    <td>
                        @if ($print->transaction_details->isNotEmpty())
                            @foreach ($print->transaction_details as $detail)
                                {{ $detail->sub_total }}<br>
                            @endforeach
                        @elseif ($print->transaction_details_kiloan->isNotEmpty())
                            @foreach ($print->transaction_details_kiloan as $detail)
                                {{ $detail->sub_total }}<br>
                            @endforeach
                        @else
                            Tidak ada sub total
                        @endif
                    </td>
                    <td>{{ $print->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- <div class="relative overflow-x-auto">
        <table class="w-full text-xs text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="">
                        No
                    </th>
                    <th scope="col" class="">
                        Kode Transaksi
                    </th>
                    <th scope="col" class="">
                        No.Telp
                    </th>
                    <th scope="col" class="">
                        Jenis Pesanan
                    </th>
                    <th scope="col" class="">
                        Alamat
                    </th>
                    <th scope="col" class="">
                        Sub Total
                    </th>
                    <th scope="col" class="">
                        Total Harga
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <td class="px-6 py-4">
                        Silver
                    </td>
                    <td class="px-6 py-4">
                        Laptop
                    </td>
                    <td class="px-6 py-4">
                        $2999
                    </td>
                </tr>
            </tbody>
        </table>
    </div> --}}

    {{-- <div class="row mt-3">
        <div class="col-4 text-end">
            <p>Surakarta, {{ date('d F Y') }}</p>
            <br>
            <br>
            <br>
            <p></p>
        </div>
    </div> --}}
    <footer class="text-end">
        <span class="text-muted small text-end">Dicetak pada Jakarta, {{ date('d M Y') }}</span>
        {{-- <br>
        <br>
        <br>
        <p></p> --}}
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

</body>

</html>
