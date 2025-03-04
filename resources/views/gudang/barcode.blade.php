@extends('layouts.office')
@section('title')
    BARCODE BARANG
@endsection
@section('content')
    <div class="grid columns-12 gap-6">
        <div class="g-col-12 g-col-xxl-12">
            <div class="grid columns-12 gap-6">
                <!-- BEGIN: Weekly Top Products -->
                <div class="g-col-12 mt-6">
                    <div class="intro-y d-block d-sm-flex align-items-center h-10">
                        <h2 class="fs-lg fw-medium truncate me-5">
                            BUAT BARCODE BARANG
                        </h2>
                        <div class="d-flex align-items-center ms-sm-auto mt-3 mt-sm-0">
                            <a href="{{ route('gudang.index') }}" class="btn btn-primary w-45 me-8 mb-4"> <i
                                    data-feather="rewind" class="w-4 h-4 me-2"></i> Kembali </a>
                        </div>
                    </div>
                    <div class="container text-center">
                        <div class="row">
                            <form action="{{ route('barcode.post') }}" target="_blank" method="POST">
                                @csrf
                                <div class="col"></div>
                                <div class="col">

                                    <div class="input-group w-56 mx-auto">
                                        <div id="input-group-email" class="input-group-text"> <i data-feather="slack"
                                                class="w-4 h-4"></i> </div> <input type="text" class=" form-control"
                                            data-single-mode="true" name="barcode" id="barcode" value="{{ old('barcode') }}">
                                            <p class="text-danger">{{ $errors->first('barcode') }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="col">

                                    <div class="input-group w-56 mx-auto">
                                        <div id="input-group-email" class="input-group-text"> <i data-feather="plus-circle"
                                                class="w-4 h-4"></i> </div> <input type="text" class=" form-control"
                                            data-single-mode="true" name="jumlah" id="jumlah" value="{{ old('jumlah') }}">
                                            <p class="text-danger">{{ $errors->first('jumlah') }}</p>
                                    </div>
                                </div>
                                <br>
                                <div class="col">

                                    <button type="submit" class="btn btn-primary w-32 me-2 mb-2" id="btn-filter"> <i data-feather="printer"
                                            class="w-4 h-4 me-2"></i> Cetak </button>
                                </div>
                                <div class="col"></div>

                            </form>
                        </div>
                        <br>

                    </div>

                </div>
                <!-- END: Weekly Top Products -->
            </div>
        </div>
    </div>
@endsection

