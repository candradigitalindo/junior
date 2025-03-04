@extends('layouts.office')
@section('title')
Finance
@endsection
@section('content')
<div class="grid columns-12 gap-6">
    <div class="g-col-12 g-col-xxl-12">
        <div class="grid columns-12 gap-6">
             <!-- BEGIN: General Report -->
             <div class="g-col-12 mt-8">
                <div class="grid columns-12 gap-6 mt-5">
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="bar-chart" class="report-box__icon text-theme-10"></i>

                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">4.710</div>
                                <div class="fs-base text-gray-600 mt-1">Pendapatan per bulan</div>
                            </div>
                        </div>
                    </div>
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="bar-chart-2" class="report-box__icon text-theme-11"></i>
                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">3.721</div>
                                <div class="fs-base text-gray-600 mt-1">Pengeluaran per bulan</div>
                            </div>
                        </div>
                    </div>
                    <div class="g-col-12 g-col-sm-6 g-col-xl-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="d-flex">
                                    <i data-feather="coffee" class="report-box__icon text-theme-12"></i>
                                </div>
                                <div class="report-box__total fs-3xl fw-medium mt-6">2</div>
                                <div class="fs-base text-gray-600 mt-1">Laba Bersih</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END: General Report -->
            <!-- BEGIN: Weekly Top Products -->
            <div class="g-col-12 mt-6">
                <div class="intro-y d-block d-sm-flex align-items-center h-10">
                    <h2 class="fs-lg fw-medium truncate me-5">
                        Tabel Pending Pengeluaran
                    </h2>
                </div>
                <br>
                <div class="intro-y overflow-auto overflow-lg-visible mt-8 mt-sm-0">
                    <table class="table table-bordered display" id="tabel-category" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-nowrap" style="width: 5%">No</th>
                                <th class="text-nowrap">Nama Pengeluaran</th>
                                <th class="text-nowrap">Jumlah</th>
                                <th class="text-nowrap">Deskripsi</th>
                                <th class="text-center text-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="intro-x">
                                <td>1</td>

                                <td>
                                    <a href="" class="fw-medium text-nowrap">Sony A7 III</a>
                                    <div class="text-gray-600 fs-xs text-nowrap mt-0.5">Photography</div>
                                </td>
                                <td>0</td>
                                <td>
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur alias libero rerum sequi corrupti, dicta incidunt beatae, distinctio blanditiis eaque ratione harum laudantium fugiat! Expedita, minus veniam. Reiciendis, quos debitis.
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a class="d-flex align-items-center justify-content-center text-theme-9" href=""> <i data-feather="check-square" class="w-4 h-4 me-1"></i> Approve </a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="intro-x">
                                <td>1</td>

                                <td>
                                    <a href="" class="fw-medium text-nowrap">Sony A7 III</a>
                                    <div class="text-gray-600 fs-xs text-nowrap mt-0.5">Photography</div>
                                </td>
                                <td>0</td>
                                <td>
                                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur alias libero rerum sequi corrupti, dicta incidunt beatae, distinctio blanditiis eaque ratione harum laudantium fugiat! Expedita, minus veniam. Reiciendis, quos debitis.
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <a class="d-flex align-items-center justify-content-center text-theme-9" href=""> <i data-feather="check-square" class="w-4 h-4 me-1"></i> Approve </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Weekly Top Products -->
        </div>
    </div>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
@endsection
@section('js')
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#tabel-category').DataTable();
    } );
</script>
@endsection
