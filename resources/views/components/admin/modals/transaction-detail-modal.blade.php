<div class="modal fade" id="transactionDetailModal" tabindex="-1" role="dialog"
    aria-labelledby="transactionDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-blue-600">
                <h5 class="modal-title text-white" id="transactionDetailModalLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>ID Transaksi: <span id="id-transaksi-detail"></span></h5>
                <h5>Kode Transaksi: <span id="code-transaksi-detail"></span></h5>
                {{-- <table id="tbl-detail-transaksi-satuan" class="table dt-responsive nowrap" style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Servis</th>
                            <th>Kategori</th>
                            <th>Banyak</th>
                            <th>Harga</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbl-ajax">
                    </tbody>
                </table>
                <br>
                <table id="tbl-detail-transaksi-kiloan" class="table dt-responsive nowrap" style="width: 100%">
                    <thead class="thead-light">
                        <tr>
                            <th>No</th>
                            <th>Kategori</th>
                            <th>Berat</th>
                            <th>Harga</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbl-ajax-kiloan">
                    </tbody>
                </table> --}}
                <div id="section-satuan">
                    <table class="table dt-responsive nowrap" style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Barang</th>
                                <th>Servis</th>
                                <th>Kategori</th>
                                <th>Banyak</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="tbl-ajax">
                        </tbody>
                    </table>
                </div>

                <!-- Tabel Transaksi Kiloan -->
                <div id="section-kiloan">
                    <table class="table dt-responsive nowrap" style="width: 100%">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Kategori</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody id="tbl-ajax-kiloan">
                        </tbody>
                    </table>
                </div>
                <br>
                <br>
                <h5>Tipe Service: <span id="service-type"></span></h5>
                <h5>Dibayar: <span id="payment-amount"></span></h5>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
