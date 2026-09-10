<?php

namespace App\Exports;

use App\Models\StokObat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StokObatExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        // Tarik data stok beserta relasinya
        return StokObat::with(['masterObat', 'gudang'])->latest()->get();
    }

    public function headings(): array
    {
        // Judul kolom di baris pertama Excel
        return [
            'No', 'Kode Barang', 'Nama Barang', 'Kategori', 'No Batch', 'Expired Date', 'Lokasi Gudang', 'Sisa Stok', 'Satuan'
        ];
    }

    public function map($stok): array
    {
        // Pemetaan isi baris (otomatis *looping*)
        static $no = 1;
        return [
            $no++,
            $stok->masterObat->kode_obat ?? '-',
            $stok->masterObat->nama_obat ?? '-',
            $stok->masterObat->kategori ?? '-',
            $stok->no_batch,
            $stok->exp_date ? date('d-m-Y', strtotime($stok->exp_date)) : 'Belum diset',
            $stok->gudang->nama_gudang ?? '-',
            $stok->jumlah,
            $stok->masterObat->satuan ?? '-'
        ];
    }
}