@extends('layouts.office')

@section('title')
    Cetak Barcode | JUNIOR AUTO CARE
@endsection

@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12">
            <div class="intro-y d-flex flex-column flex-sm-row align-items-center mt-8">
                <h2 class="fs-2xl fw-bold truncate me-auto">
                    Pembuatan Label Barcode
                </h2>
                <div class="w-full w-sm-auto d-flex mt-4 mt-sm-0">
                    <a href="{{ route('gudang.index') }}" class="btn btn-outline-secondary shadow-md w-32 me-2">
                        <i data-feather="corner-up-left" class="w-4 h-4 me-2"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="g-col-12 g-col-lg-6 intro-y mt-2 mx-auto">
            <div class="box p-10 text-center">
                <div class="w-20 h-20 bg-theme-1/10 text-theme-1 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-6">
                    <i data-feather="printer" class="w-10 h-10"></i>
                </div>
                <h3 class="fs-xl fw-bold mb-5">Generator Barcode</h3>
                
                <form action="{{ route('barcode.post') }}" target="_blank" method="POST" class="text-start">
                    @csrf
                    <div class="mb-5">
                        <label class="form-label fw-semibold">Kode Barcode / Nama Barang</label>
                        <div class="input-group">
                            <div class="input-group-text bg-gray-100 border-2"><i data-feather="slack" class="w-4 h-4"></i></div>
                            <input type="text" class="form-control border-2 form-control-lg" name="barcode" placeholder="Input kode atau barcode..." value="{{ old('barcode') }}" required>
                        </div>
                        @error('barcode') <p class="text-danger small mt-1 italic">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-8">
                        <label class="form-label fw-semibold">Jumlah Label (Max: 100)</label>
                        <div class="input-group">
                            <div class="input-group-text bg-gray-100 border-2"><i data-feather="copy" class="w-4 h-4"></i></div>
                            <input type="number" class="form-control border-2 form-control-lg" name="jumlah" placeholder="Contoh: 10" value="{{ old('jumlah', 1) }}" min="1" max="100" required>
                        </div>
                        @error('jumlah') <p class="text-danger small mt-1 italic">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-full py-3 fs-lg shadow-md">
                        <i data-feather="printer" class="w-5 h-5 me-2"></i> CETAK LABEL BARCODE
                    </button>
                </form>

                <div class="mt-8 p-4 bg-yellow-50 rounded-2 text-yellow-800 text-xs text-start">
                    <div class="fw-bold mb-1"><i data-feather="info" class="w-3 h-3 inline me-1"></i> Informasi Cetak:</div>
                    Pastikan printer thermal sudah terhubung dan ukuran kertas label sesuai dengan standar (30mm x 15mm atau sejenisnya).
                </div>
            </div>
        </div>
    </div>
@endsection
