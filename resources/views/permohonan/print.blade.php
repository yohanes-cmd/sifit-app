<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permohonan {{ $permohonan->nomor_permohonan }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12pt;
            line-height: 1.4;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 20px;
        }

        .no-print {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f1f5f9;
            padding: 12px 20px;
            margin-bottom: 25px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: #0284c7;
            color: #fff;
        }

        .btn-secondary {
            background: #64748b;
            color: #fff;
        }

        .kop-surat {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 20px;
            position: relative;
        }

        .kop-surat h3 {
            margin: 0;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
        }

        .kop-surat h2 {
            margin: 4px 0;
            font-size: 16pt;
            font-weight: 800;
            text-transform: uppercase;
        }

        .kop-surat p {
            margin: 0;
            font-size: 9.5pt;
        }

        .judul-dokumen {
            text-align: center;
            margin-bottom: 20px;
        }

        .judul-dokumen h4 {
            margin: 0;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .judul-dokumen span {
            font-size: 11pt;
            display: block;
            margin-top: 4px;
        }

        .meta-table {
            width: 100%;
            margin-bottom: 20px;
            font-size: 11pt;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .meta-table td.label {
            width: 25%;
            font-weight: 600;
        }

        .meta-table td.separator {
            width: 2%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            font-size: 10.5pt;
        }

        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px 8px;
        }

        .data-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }

        .ttd-container {
            width: 100%;
            margin-top: 30px;
            page-break-inside: avoid;
        }

        .ttd-table {
            width: 100%;
            border-collapse: collapse;
        }

        .ttd-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 10px;
            font-size: 11pt;
        }

        .ttd-space {
            height: 75px;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <div>
            <strong>Pratinjau Cetak Formulir Permohonan Obat</strong>
            <span style="display: block; font-size: 12px; color: #64748b;">Gunakan tombol cetak atau tekan Ctrl + P pada keyboard Anda.</span>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Cetak Dokumen Sekarang
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                Tutup Jendela
            </button>
        </div>
    </div>

    <!-- KOP RESMI -->
    <div class="kop-surat">
        <h3>Pemerintah Provinsi Riau</h3>
        <h2>Dinas Kesehatan</h2>
        <p>Instalasi Farmasi dan Pengelolaan Perbekalan Kesehatan</p>
        <p>Jalan Cut Nyak Dien No. 2, Pekanbaru, Riau | Telp: (0761) 23810 | Email: farmasi@dinkes.riau.go.id</p>
    </div>

    <!-- JUDUL SURAT -->
    <div class="judul-dokumen">
        <h4>Surat Permohonan Alokasi Obat & Logistik Farmasi</h4>
        <span>Nomor: <strong>{{ $permohonan->nomor_permohonan }}</strong></span>
    </div>

    <!-- META DATA -->
    <table class="meta-table">
        <tr>
            <td class="label">Instansi Pemohon (OPD)</td>
            <td class="separator">:</td>
            <td><strong>{{ $permohonan->opd->nama_opd ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Tanggal Pengajuan</td>
            <td class="separator">:</td>
            <td>{{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td class="label">Keperluan / Program</td>
            <td class="separator">:</td>
            <td>{{ $permohonan->keperluan ?: 'Kebutuhan Distribusi Layanan Obat Rutin' }}</td>
        </tr>
        <tr>
            <td class="label">Status Pengajuan</td>
            <td class="separator">:</td>
            <td>{{ $permohonan->status_label }}</td>
        </tr>
        @if($permohonan->catatan)
        <tr>
            <td class="label">Catatan Tambahan</td>
            <td class="separator">:</td>
            <td>{{ $permohonan->catatan }}</td>
        </tr>
        @endif
    </table>

    <!-- TABEL OBAT / ACUAN BARANG -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Kode Obat</th>
                <th>Nama Obat / Logistik Kesehatan</th>
                <th width="12%">Satuan</th>
                <th width="14%">Jumlah Diminta</th>
                <th width="14%">Jumlah Disetujui</th>
                <th width="18%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permohonan->detailPermohonans as $idx => $detail)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td class="text-center">{{ $detail->masterObat->kode_obat ?? '-' }}</td>
                    <td>
                        {{ $detail->masterObat->nama_obat ?? '-' }}
                        @if(!empty($detail->masterObat?->kode_kemkes))
                            <span style="font-size: 8.5pt; color: #555;">({{ $detail->masterObat->kategori === 'Logistik' ? 'Kemkes: ' : 'Batch: ' }}{{ $detail->masterObat->kode_kemkes }})</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $detail->masterObat->satuan ?? 'Pcs' }}</td>
                    <td class="text-center text-bold">{{ number_format($detail->jumlah_diminta) }}</td>
                    <td class="text-center text-bold">{{ number_format($detail->jumlah_disetujui ?? $detail->jumlah_diminta) }}</td>
                    <td>{{ $detail->catatan ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="text-bold" style="background-color: #fafafa;">
                <td colspan="4" class="text-right">Total Kuantitas:</td>
                <td class="text-center">{{ number_format($permohonan->total_diminta) }}</td>
                <td class="text-center">{{ number_format($permohonan->total_disetujui) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- CATATAN DINKES -->
    @if($permohonan->catatan_verifikasi)
    <div style="font-size: 10pt; margin-bottom: 20px; padding: 6px 10px; border: 1px dashed #64748b; border-radius: 4px;">
        <strong>Catatan Verifikasi UPT Farmasi:</strong> {{ $permohonan->catatan_verifikasi }}
    </div>
    @endif

    <!-- TANDA TANGAN -->
    <div class="ttd-container">
        <table class="ttd-table">
            <tr>
                <td>
                    Mengetahui / Memeriksa,<br>
                    <strong>Pengelola Farmasi & Logistik</strong>
                    <div class="ttd-space"></div>
                    <strong>( {{ $permohonan->verifiedBy->name ?? '............................................' }} )</strong><br>
                    NIP. .....................................................
                </td>
                <td>
                    Pekanbaru, {{ \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->translatedFormat('d F Y') }}<br>
                    Pemohon / Perwakilan Instansi,<br>
                    <strong>{{ $permohonan->opd->nama_opd ?? 'OPD Pemohon' }}</strong>
                    <div class="ttd-space"></div>
                    <strong>( {{ $permohonan->user->name ?? '............................................' }} )</strong><br>
                    NIP. .....................................................
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
