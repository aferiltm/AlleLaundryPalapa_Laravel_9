<div class="modal fade" id="addVoucherModal" tabindex="-1" role="dialog" aria-labelledby="addVoucherModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addVoucherModalLabel">Tambah Voucher</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.vouchers.store') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="potongan">Potongan</label>
                        <input type="number" class="form-control" id="potongan" name="discount_value"
                            placeholder="Besar potongan harga" required>
                    </div>
                    <div class="form-group">
                        <label for="poin">Poin diperlukan</label>
                        <input type="number" class="form-control" id="poin" name="point_need"
                            placeholder="Poin diperlukan" required>
                    </div>
                    <div class="form-group">
                        <label for="poin">Detail Promo Voucher</label>
                        <textarea rows="3" type="text" class="form-control" id="details" name="details"
                            placeholder="Detail Voucher" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
