<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Keluar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin ingin keluar?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn text-gray-700 border-gray-700 hover:text-white hover:bg-gray-700" data-dismiss="modal">Batal</button>
                <a href="{{ route('login.logout') }}" class="btn text-red-700 border-red-700 hover:text-white hover:bg-red-700">Keluar</a>
            </div>
        </div>
    </div>
</div>
