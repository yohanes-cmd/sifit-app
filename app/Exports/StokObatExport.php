<?php

namespace App\Exports;

use App\Models\StokObat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StokObatExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public ?int $gudangId = null) {}

    public function collection(): Collection
    {
        $query = StokObat::with(['masterObat', 'gudang'])->latest();

        if ($this->gudangId) {
            $query->where('gudang_id', $this->gudangId);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Obat/Logistik',
            'Nama Obat/Logistik',
            'Sub Kategori',
            'Kategori',
            'Satuan',
            'Peringatan Jumlah',
            'Harga Satuan (Rp)',
            'Jumlah Barang',
            'Date Expired',
            'Gudang',
            'Keterangan',
            'Total Nilai (Rp)',
        ];
    }

    public function map($stok): array
    {
        static $no = 1;

        return [
            $no++,
            $stok->display_kode,
            $stok->display_nama,
            $stok->sub_kategori ?? '-',
            $stok->display_kategori,
            $stok->display_satuan,
            $stok->peringatan_jumlah ?? 10,
            $stok->display_harga,
            $stok->jumlah,
            $stok->exp_date ? $stok->exp_date->format('Y-m-d') : '-',
            $stok->gudang->nama_gudang ?? '-',
            $stok->keterangan ?? '-',
            $stok->total_nilai,
        ];
    }
}
