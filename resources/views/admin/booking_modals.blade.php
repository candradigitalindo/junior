{{-- Modal Pengecekan --}}
<div id="modal-pengecekan" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-medium fs-base me-auto">CEK KENDARAAN</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="g-col-12">
                    <label class="form-label">No Pol. Kendaraan</label>
                    <input type="text" class="form-control" id="cno_pol_kendaraan" disabled>
                </div>
                <div class="g-col-12">
                    <label class="form-label">Tipe Mobil</label>
                    <input type="text" class="form-control" id="ctipe_mobil" disabled>
                </div>
                <div class="g-col-12">
                    <label class="form-label">Bagian Exterior</label>
                    <textarea class="form-control" id="cexterior" rows="3" disabled></textarea>
                </div>
                <div class="g-col-12">
                    <label class="form-label">Bagian Interior</label>
                    <textarea class="form-control" id="cinterior" rows="3" disabled></textarea>
                </div>
                <div class="g-col-12">
                    <label class="form-label">Mesin</label>
                    <textarea class="form-control" id="cmesin" rows="3" disabled></textarea>
                </div>
                <div class="g-col-12">
                    <label class="form-label">Barang didalam Mobil</label>
                    <textarea class="form-control" id="cbarang_mobil" rows="3" disabled></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-secondary w-24">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Pengerjaan --}}
<div class="modal fade" id="modal-pengerjaan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-medium fs-base me-auto">LOG PEKERJAAN</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-5">
                    <label class="form-label">No Pol. Kendaraan</label>
                    <input type="text" class="form-control" id="pno_pol_kendaraan" disabled>
                </div>
                <div class="overflow-x-auto">
                    <table class="table table-bordered w-full" id="tabel-histori">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-gray-500 fw-bold">AKTIVITAS / LOG</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary w-24" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Photo --}}
<div class="modal fade" id="modal-photo" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-medium fs-base me-auto">FOTO PENGECEKAN</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="overflow-x-auto">
                    <table class="table table-bordered w-full" id="tabel-photo">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-gray-500 fw-bold">DOKUMENTASI FOTO</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary w-24" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Orderan --}}
<div class="modal fade" id="modal-orderan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-medium fs-base me-auto">DETAIL ORDERAN</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="grid grid-cols-12 gap-4 mb-5">
                    <div class="g-col-12 g-col-md-6">
                        <label class="form-label">No Pol. Kendaraan</label>
                        <input type="text" class="form-control" id="ono_pol_kendaraan" disabled>
                    </div>
                    <div class="g-col-12 g-col-md-6">
                        <label class="form-label">Tambah Layanan</label>
                        <div class="d-flex gap-2">
                            <select id="product" class="form-select flex-1 shadow-none border-gray-200">
                                <option value="">--- Pilih Layanan ---</option>
                            </select>
                            <button type="button" class="btn btn-primary shadow-none px-4" id="simpan_orderan">Tambah</button>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="orderan_booking_id">
                <div class="overflow-x-auto border rounded-lg">
                    <table class="table table-hover w-full" id="tabel-orderan">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-gray-500 fw-bold">ITEM LAYANAN / PRODUK</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary w-24" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
