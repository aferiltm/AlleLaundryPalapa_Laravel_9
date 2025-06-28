<div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addItemModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addItemModalLabel">Tambah Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.items.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="barang">Nama Barang</label>
                        <input type="text" class="form-control" id="barang" name="item_name">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-gray-700 border-gray-700 hover:text-white hover:bg-gray-700" data-dismiss="modal">Close</button>
                <button type="submit" class="btn text-blue-900 border-blue-900 hover:text-white hover:bg-blue-900">Tambah Barang</button>
                </form>
            </div>
        </div>
    </div>
</div>
