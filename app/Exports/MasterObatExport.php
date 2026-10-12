<?php

namespace App\Exports;

use App\Models\MasterObat;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterObatExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct(public ?string $search = null) {}

    public function collection(): Collection
    {
        $query = MasterObat::latest();

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('kode_obat', 'like', "%{$this->search}%")
                    ->orWhere('nama_obat', 'like', "%{$this->search}%")
                    ->orWhere('kode_kemkes', 'like', "%{$this->search}%")
                    ->orWhere('kategori', 'like', "%{$this->search}%");
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Obat/Logistik',
            'Nama Obat/Logistik',
            'Kode Kemkes',
            'Kategori (Jenis)',
            'Satuan',
            'Harga (Rp)',
            'Status',
        ];
    }

    public function map($item): array
    {
        static $no = 1;

        return [
            $no++,
            $item->kode_obat,
            $item->nama_obat,
            $item->kode_kemkes ?? '-',
            $item->kategori,
            $item->satuan ?? 'Pcs',
            $item->harga ?? 0,
            $item->status ?? 'published',
        ];
    }
}
