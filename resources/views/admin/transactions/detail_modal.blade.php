<div>
    <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
    <p><strong>Kode Transaksi:</strong> {{ $transaction->kode }}</p>
    <p><strong>Tipe Service:</strong> {{ $transaction->service_type }}</p>

    @if ($transaction->items->count())
        <h5>Detail Satuan</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Barang</th>
                    <th>Service</th>
                    <th>Kategori</th>
                    <th>Banyak</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->service->name ?? '-' }}</td>
                        <td>{{ $item->category ?? '-' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>Rp{{ number_format($item->price) }}</td>
                        <td>Rp{{ number_format($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    @if ($transaction->kiloans->count())
        <h5>Detail Kiloan</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Berat (kg)</th>
                    <th>Harga</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->kiloans as $kiloan)
                    <tr>
                        <td>{{ $kiloan->category }}</td>
                        <td>{{ $kiloan->weight }}</td>
                        <td>Rp{{ number_format($kiloan->price) }}</td>
                        <td>Rp{{ number_format($kiloan->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <p><strong>Uang Dibayar:</strong> Rp{{ number_format($transaction->amount_paid) }}</p>
    <p><strong>Kembalian:</strong> Rp{{ number_format($transaction->change) }}</p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>
