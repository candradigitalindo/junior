<!-- NEW BOOKING MODAL -->
<div id="modal-tambah" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold fs-xl me-auto">Registrasi Pesanan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-10">
                <div class="alert alert-danger print-error-msg mb-5" style="display:none" id="error">
                    <ul class="mb-0"></ul>
                </div>
                <div class="grid grid-cols-12 gap-6">
                    <div class="g-col-12 g-col-sm-6">
                        <label class="form-label fw-semibold">Nomor Polisi</label>
                        <input type="text" class="form-control form-control-lg border-2" placeholder="BK 1234 ABC" id="no_pol_kendaraan">
                    </div>
                    <div class="g-col-12 g-col-sm-6">
                        <label class="form-label fw-semibold">Nama Pelanggan</label>
                        <input type="text" class="form-control form-control-lg border-2" placeholder="Nama Lengkap" id="name_pelanggan">
                    </div>
                    <div class="g-col-12 g-col-sm-6">
                        <label class="form-label fw-semibold">Tipe Mobil</label>
                        <select id="tipe_mobil" class="form-select form-select-lg border-2 loket-searchable-select" data-live-search="true" data-live-search-placeholder="Cari tipe mobil" data-none-selected-text="Pilih tipe mobil" data-none-results-text="Tipe mobil tidak ditemukan" data-size="8" data-width="100%" data-container="body" data-dropup-auto="false"></select>
                    </div>
                    <div class="g-col-12 g-col-sm-6">
                        <label class="form-label fw-semibold">Nomor WhatsApp</label>
                        <input type="number" class="form-control form-control-lg border-2" placeholder="0812..." id="phone">
                    </div>
                    <div class="g-col-12">
                        <label class="form-label fw-semibold">Status Kendaraan</label>
                        <select id="status_kendaraan" class="form-select form-select-lg border-2 loket-searchable-select" data-live-search="true" data-live-search-placeholder="Cari status kendaraan" data-none-selected-text="Pilih status kendaraan" data-none-results-text="Status kendaraan tidak ditemukan" data-size="8" data-width="100%" data-container="body" data-dropup-auto="false">
                            <option value="Ditunggu">Ditunggu (Waiting)</option>
                            <option value="Ditinggal">Ditinggal (Left Behind)</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="id">
            </div>
            <div class="modal-footer bg-gray-50">
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-32 me-2">Batal</button>
                <button type="button" class="btn btn-primary w-40" id="simpan">Simpan Pesanan</button>
            </div>
        </div>
    </div>
</div>

<!-- PHOTO MODAL -->
<div class="modal fade" id="modal-photo" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold fs-xl me-auto">Dokumentasi Kendaraan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-8">
                <form enctype="multipart/form-data" id="form-photo" class="mb-8 p-5 border-2 border-dashed rounded-3 bg-gray-50">
                    @csrf
                    <div class="grid grid-cols-12 gap-4">
                        <div class="g-col-12 g-col-sm-6">
                            <label class="form-label fw-semibold">Pilih Foto</label>
                            <input type="file" class="form-control" name="photo" required>
                        </div>
                        <div class="g-col-12 g-col-sm-6">
                            <label class="form-label fw-semibold">Keterangan</label>
                            <input type="text" class="form-control" name="name" placeholder="Tampak Depan, Samping, dll." required>
                        </div>
                    </div>
                    <input type="hidden" id="photo_booking_id">
                    <button type="submit" class="btn btn-primary w-full mt-4" id="simpan_photo">Unggah Dokumentasi</button>
                </form>
                
                <table class="table table-report w-full" id="tabel-photo">
                    <thead><tr><th>PREVIEW & DETAIL FOTO</th></tr></thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ORDERAN / SERVICES MODAL -->
<div class="modal fade loket-service-modal" id="modal-orderan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold fs-xl me-auto">Kelola Layanan</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="loket-service-modal__body">
                    <div class="loket-service-panel loket-service-panel--form">
                        <div class="loket-service-panel__eyebrow">Tambah layanan baru</div>
                        <div class="grid grid-cols-12 gap-4 text-start">
                            <div class="g-col-12 g-col-lg-6">
                                <label class="form-label fw-semibold">Layanan Utama</label>
                                <select id="product" class="form-select border-2 loket-searchable-select" data-live-search="true" data-live-search-placeholder="Cari layanan" data-none-selected-text="Pilih layanan" data-none-results-text="Layanan tidak ditemukan" data-size="8" data-width="100%" data-container="body" data-dropup-auto="false"></select>
                            </div>
                            <div class="g-col-12 g-col-lg-6" id="form-extraservice" style="display:none">
                                <label class="form-label fw-semibold">Layanan Tambahan</label>
                                <select id="extraservice" class="form-select border-2 loket-searchable-select" data-live-search="true" data-live-search-placeholder="Cari layanan tambahan" data-none-selected-text="Pilih extra layanan" data-none-results-text="Extra layanan tidak ditemukan" data-size="8" data-width="100%" data-container="body" data-dropup-auto="false"></select>
                            </div>
                        </div>
                        <div class="loket-empty-state d-none mt-4" id="product-empty-state"></div>
                        <input type="hidden" id="orderan_booking_id">
                        <div class="loket-service-actions">
                            <button type="button" class="btn btn-primary w-full w-sm-auto" id="simpan_orderan">Tambah ke Pesanan</button>
                        </div>
                    </div>

                    <div class="loket-service-panel loket-service-panel--list">
                        <div class="loket-service-panel__eyebrow">Layanan pada booking</div>
                        <div class="loket-service-table-wrap">
                            <table class="table table-report w-full" id="tabel-orderan">
                                <thead><tr><th>DETAIL LAYANAN</th></tr></thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- COMPLETED TODAY MODAL -->
<div class="modal fade" id="modal-selesai" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold fs-xl me-auto">Kendaraan Selesai ({{ date('d M Y') }})</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="overflow-x-auto">
                    <table class="table table-report" id="tabel-selesai" width="100%">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">NO</th>
                                <th class="text-nowrap">PLAT KENDARAAN</th>
                                <th class="text-nowrap">LAYANAN YANG DIAMBIL</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
