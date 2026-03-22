<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Rumah Nelayan - SIRUKUN</title>
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

        .meta-info {
            display: flex;
            margin-bottom: 12px;
            font-size: 10px;
        }

        .meta-info table {
            width: 100%;
        }

        .meta-info td {
            padding: 2px 0;
        }

        .meta-info .label {
            font-weight: 600;
            width: 120px;
            color: #555;
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
            width: 33.33%;
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
            vertical-align: middle;
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

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
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
        <h1>LAPORAN RUMAH NELAYAN</h1>
        <h2>Sistem Informasi Rukun Warga & Perumahan (SIRUKUN)</h2>
        <p>Dicetak pada: {{ $tanggalCetak }} — Oleh: {{ $namaPimpinan }}</p>
    </div>

    {{-- Summary --}}
    <div class="summary">
        <table>
            <tr>
                <td>
                    <div class="label">Total Unit Rumah</div>
                    <div class="value">{{ $totalUnit }}</div>
                </td>
                <td>
                    <div class="label">Unit Dihuni</div>
                    <div class="value">{{ $unitDihuni }}</div>
                </td>
                <td>
                    <div class="label">Unit Tersedia</div>
                    <div class="value">{{ $unitTersedia }}</div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Data Table --}}
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 8%;">Blok</th>
                <th style="width: 8%;">Nomor</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 25%;">Nama Penghuni</th>
                <th style="width: 18%;">NIK</th>
                <th style="width: 15%;">No. Telepon</th>
                <th style="width: 12%;">Tgl. Masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $index => $unit)
                @php
                    $penghuni = $unit->penempatan?->pengajuan?->warga;
                    $tanggalMasuk = $unit->penempatan?->tanggal_masuk;
                @endphp
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ $unit->blok }}</td>
                    <td>{{ $unit->nomor }}</td>
                    <td>
                        <span class="badge badge-{{ $unit->status_ketersediaan->getColor() }}">
                            {{ $unit->status_ketersediaan->getLabel() }}
                        </span>
                    </td>
                    <td>{{ $penghuni?->nama ?? '—' }}</td>
                    <td>{{ $penghuni?->nik ?? '-' }}</td>
                    <td>{{ $penghuni?->telepon ?? '-' }}</td>
                    <td>{{ $tanggalMasuk ? $tanggalMasuk->format('d/m/Y') : '-' }}</td>
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