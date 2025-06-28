<div class="modal fade" id="addServiceModal" tabindex="-1" role="dialog" aria-labelledby="addServiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addServiceModalLabel">Tambah Servis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.services.store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="servis">Nama Servis</label>
                        <input type="text" class="form-control" id="servis" name="service_name">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-gray-700 border-gray-700 hover:text-white hover:bg-gray-700" data-dismiss="modal">Close</button>
                <button type="submit" class="btn text-red-700 border-red-700 hover:text-white hover:bg-red-700">Tambah Servis</button>
                </form>
            </div>
        </div>
    </div>
</div>
