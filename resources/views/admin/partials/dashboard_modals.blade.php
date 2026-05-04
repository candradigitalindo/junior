<!-- Daily Modal -->
<div class="modal fade" id="modal-harian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px !important; overflow: hidden !important;">
            <div class="modal-header pt-6 px-4 px-md-8" style="background-color: #f8fafc !important; border-bottom: 1px solid #e2e8f0 !important;">
                <div>
                    <h2 class="fw-bold fs-xl fs-md-2xl" style="color: #1e293b !important;">Rincian Harian</h2>
                    <div class="text-muted fs-xs mt-1" style="color: #64748b !important;">Periode {{ date('F Y') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 px-md-8 pb-8" style="background-color: #ffffff !important;">
                <!-- Hyper-Minimalist Summary Cards -->
                <div class="row g-1 mb-6">
                    <div class="col-2">
                        <div style="background-color: rgba(16, 185, 129, 0.1) !important; color: #10b981 !important; padding: 8px 4px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.55rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Omzet</div>
                            <div style="font-size: 0.75rem; font-weight: 900;">{{ number_format(collect($dailyData)->sum('revenue'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div style="background-color: rgba(139, 92, 246, 0.1) !important; color: #8b5cf6 !important; padding: 8px 4px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.55rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Lain</div>
                            <div style="font-size: 0.75rem; font-weight: 900;">{{ number_format(collect($dailyData)->sum('other_income'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div style="background-color: rgba(239, 68, 68, 0.1) !important; color: #ef4444 !important; padding: 8px 4px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.55rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Keluar</div>
                            <div style="font-size: 0.75rem; font-weight: 900;">{{ number_format(collect($dailyData)->sum('expense'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div style="background-color: rgba(37, 99, 235, 0.1) !important; color: #2563eb !important; padding: 8px 4px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.55rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Piutang</div>
                            <div style="font-size: 0.75rem; font-weight: 900;">{{ number_format(collect($dailyData)->sum('unpaid'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div style="background-color: rgba(30, 41, 59, 0.1) !important; color: #1e293b !important; padding: 8px 4px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 0.55rem; font-weight: 700; text-transform: uppercase; margin-bottom: 2px;">Laba</div>
                            <div style="font-size: 0.75rem; font-weight: 900;">{{ number_format(collect($dailyData)->sum('net'), 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>

                <div style="border-radius: 12px !important; border: 1px solid #e2e8f0 !important;">
                    <table class="table table-sm table-hover mb-0" style="font-size: 0.68rem !important; width: 100% !important; table-layout: fixed !important;">
                        <thead style="background-color: #f8fafc !important;">
                            <tr>
                                <th style="padding: 10px 2px !important; color: #64748b !important; font-weight: 700 !important; width: 12%;">Tgl</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #10b981 !important; font-weight: 700 !important;">Omzet</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #8b5cf6 !important; font-weight: 700 !important;">Lain</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #ef4444 !important; font-weight: 700 !important;">Keluar</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #2563eb !important; font-weight: 700 !important;">Piutang</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #1e293b !important; font-weight: 800 !important;">Net</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #ffffff !important;">
                            @foreach ($dailyData as $val)
                                <tr style="{{ $val['revenue'] > 0 ? 'background-color: rgba(16, 185, 129, 0.03) !important;' : '' }}">
                                    <td style="padding: 8px 2px !important; font-weight: 600 !important; white-space: nowrap;">{{ $val['day'] }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #10b981 !important;">{{ number_format($val['revenue'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #8b5cf6 !important;">{{ number_format($val['other_income'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #ef4444 !important;">{{ number_format($val['expense'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #2563eb !important;">{{ number_format($val['unpaid'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #1e293b !important; font-weight: 800 !important;">{{ number_format($val['net'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Monthly Modal -->
<div class="modal fade" id="modal-rincian" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px !important; overflow: hidden !important;">
            <div class="modal-header pt-6 px-4 px-md-8" style="background-color: #f8fafc !important; border-bottom: 1px solid #e2e8f0 !important;">
                <div>
                    <h2 class="fw-bold fs-xl fs-md-2xl" style="color: #1e293b !important;">Rincian Bulanan</h2>
                    <div class="text-muted fs-xs mt-1" style="color: #64748b !important;">Tahun {{ date('Y') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body px-4 px-md-8 pb-8" style="background-color: #ffffff !important;">
                <div style="border-radius: 12px !important; border: 1px solid #e2e8f0 !important;">
                    <table class="table table-sm table-hover mb-0" style="font-size: 0.68rem !important; width: 100% !important; table-layout: fixed !important;">
                        <thead style="background-color: #f8fafc !important;">
                            <tr>
                                <th style="padding: 10px 2px !important; color: #64748b !important; font-weight: 700 !important; width: 15%;">Bulan</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #10b981 !important; font-weight: 700 !important;">Omzet</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #8b5cf6 !important; font-weight: 700 !important;">Lain</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #ef4444 !important; font-weight: 700 !important;">Keluar</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #2563eb !important; font-weight: 700 !important;">Piutang</th>
                                <th class="text-end" style="padding: 10px 2px !important; color: #1e293b !important; font-weight: 800 !important;">Net</th>
                            </tr>
                        </thead>
                        <tbody style="background-color: #ffffff !important;">
                            @foreach ($chartData as $item)
                                <tr style="{{ $item['revenue'] > 0 ? 'background-color: rgba(37, 99, 235, 0.03) !important;' : '' }}">
                                    <td style="padding: 8px 2px !important; font-weight: 600 !important; white-space: nowrap;">{{ $item['month'] }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #10b981 !important; font-weight: 700 !important;">{{ number_format($item['revenue'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #8b5cf6 !important;">{{ number_format($item['other_income'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #ef4444 !important;">{{ number_format($item['expense'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #2563eb !important; font-weight: 700 !important;">{{ number_format($item['unpaid'], 0, ',', '.') }}</td>
                                    <td class="text-end" style="padding: 8px 2px !important; color: #1e293b !important; font-weight: 800 !important;">{{ number_format($item['net'], 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #f8fafc !important; font-weight: 900 !important;">
                            <tr style="border-top: 2px solid #e2e8f0 !important;">
                                <td style="padding: 12px 2px !important;">TOTAL</td>
                                <td class="text-end" style="padding: 12px 2px !important; color: #10b981 !important;">{{ number_format(collect($chartData)->sum('revenue'), 0, ',', '.') }}</td>
                                <td class="text-end" style="padding: 12px 2px !important; color: #8b5cf6 !important;">{{ number_format(collect($chartData)->sum('other_income'), 0, ',', '.') }}</td>
                                <td class="text-end" style="padding: 12px 2px !important; color: #ef4444 !important;">{{ number_format(collect($chartData)->sum('expense'), 0, ',', '.') }}</td>
                                <td class="text-end" style="padding: 12px 2px !important; color: #2563eb !important;">{{ number_format(collect($chartData)->sum('unpaid'), 0, ',', '.') }}</td>
                                <td class="text-end" style="padding: 12px 2px !important; color: #1e293b !important;">{{ number_format(collect($chartData)->sum('net'), 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
