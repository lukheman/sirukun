<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keluhan Warga - SIRUKUN</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 12px;
            margin-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 3px;
        }

        .header h2 {
            font-size: 14px;
            font-weight: 600;
            color: #555;
            margin-bottom: 3px;
        }

        .header p {
            font-size: 10px;
            color: #888;
        }

        .summary {
            margin-bottom: 15px;
        }

        .summary table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: center;
            width: 25%;
        }

        .summary .label {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            margin-bottom: 3px;
        }

        .summary .value {
            font-size: 18px;
            font-weight: 700;
            color: #333;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .data-table thead th {
            background-color: #4a3728;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .data-table tbody td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 10px;
            vertical-align: top;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f9f7f5;
        }

        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 600;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .text-muted {
            color: #888;
        }

        .balasan-box {
            background-color: #f0f7f0;
            border: 1px solid #c3e6c3;
            border-radius: 4px;
            padding: 4px 6px;
            margin-top: 4px;
            font-size: 9px;
        }

        .balasan-label {
            font-weight: 600;
            color: #155724;
            font-size: 8px;
            text-transform: uppercase;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #aaa;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    {{-- Header --}}
    <div class="header">
        <h1>LAPORAN KELUHAN WARGA</h1>
        <h2>Sistem Informasi Rukun Warga & Perumahan (SIRUKUN)</h2>
        <p>Dicetak pada: {{ $tanggalCetak }} — Oleh: {{ $namaPencetak }}</p>
        @if(!empty($filterInfo))
            <p style="margin-top: 5px; color: #C75B3F; font-weight: bold; font-size: 10px;">
                Filter Aktif: {{ implode(', ', $filterInfo) }}
            </p>
        @endif
    </div>

    {{-- Summary --}}
    <div class="summary">
        <table>
            <tr>
                <td>
                    <div class="label">Total Keluhan</div>
                    <div class="value">{{ $totalKeluhan }}</div>
                </td>
                <td>
                    <div class="label">Menunggu</div>
                    <div class="value" style="color: #856404;">{{ $menunggu }}</div>
                </td>
                <td>
                    <div class="label">Diproses</div>
                    <div class="value" style="color: #0c5460;">{{ $diproses }}</div>
                </td>
                <td>
                    <div class="label">Selesai</div>
                    <div class="value" style="color: #155724;">{{ $selesai }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Data Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 14%;">Nama Warga</th>
                <th style="width: 10%;">NIK</th>
                <th style="width: 14%;">Judul Keluhan</th>
                <th style="width: 22%;">Isi Keluhan</th>
                <th style="width: 8%;">Status</th>
                <th style="width: 18%;">Balasan Admin</th>
                <th style="width: 10%;">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keluhans as $index => $keluhan)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $keluhan->warga->nama }}</td>
                    <td>{{ $keluhan->warga->nik }}</td>
                    <td>{{ $keluhan->judul }}</td>
                    <td>{{ Str::limit($keluhan->isi, 120) }}</td>
                    <td>
                        @php
                            $colorMap = [
                                'Menunggu' => 'warning',
                                'Diproses' => 'info',
                                'Selesai'  => 'success',
                            ];
                            $badgeClass = $colorMap[$keluhan->status->value] ?? 'warning';
                        @endphp
                        <span class="badge badge-{{ $badgeClass }}">{{ $keluhan->status->getLabel() }}</span>
                    </td>
                    <td>
                        @if($keluhan->balasan)
                            <div class="balasan-box">
                                <div class="balasan-label">Balasan:</div>
                                {{ Str::limit($keluhan->balasan, 100) }}
                                @if($keluhan->dibalas_pada)
                                    <br><span class="text-muted">({{ $keluhan->dibalas_pada->format('d/m/Y') }})</span>
                                @endif
                            </div>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $keluhan->created_at->format('d/m/Y') }}<br><span class="text-muted">{{ $keluhan->created_at->format('H:i') }}</span></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        SIRUKUN - Sistem Informasi Rukun Warga & Perumahan &copy; {{ date('Y') }}
    </div>
</body>

</html>
